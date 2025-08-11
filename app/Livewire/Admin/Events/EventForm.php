<?php

namespace App\Livewire\Admin\Events;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use DOMDocument;

class EventForm extends Component
{
    use WithFileUploads;

    public $eventId;
    public $event;
    public $title;
    public $description;
    public $event_date;
    public $tag;
    public $article;
    public $thumbnail;
    public $is_highlighted = 0;
    public $debugInfo = '';

    // listen for the Quill editor updates
    protected $listeners = [
        'quillChanged' => 'onQuillChanged'
    ];

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'tag' => 'required|string|max:255',
            'article' => 'required|string',
            'thumbnail' => $this->eventId
                ? 'nullable|image|max:5120'
                : 'required|image|max:5120',
            'is_highlighted' => 'boolean',
        ];
    }

    protected function messages()
    {
        return [
            // … your custom messages …
        ];
    }

    public function mount($eventId = null)
    {
        if ($eventId) {
            $this->eventId = $eventId;
            $this->event = Event::findOrFail($eventId);
            $this->title = $this->event->title;
            $this->description = $this->event->description;
            $this->event_date = $this->event->event_date;
            $this->tag = $this->event->tag;
            $this->article = $this->event->article;
            $this->is_highlighted = $this->event->is_highlighted;
        }
    }

    // sync thumbnail validation
    public function updatedThumbnail()
    {
        $this->validateOnly('thumbnail', ['thumbnail' => 'image|max:5120']);
        $this->debugInfo = "Thumbnail ready: " . $this->thumbnail->getClientOriginalName();
    }

    // handle any field updating (including article via listener)
    public function updated($field)
    {
        $this->validateOnly($field, $this->rules(), $this->messages());
    }

    // listener for Quill editor
    public function onQuillChanged(...$params)
    {
        // Normalize payload: supports (model, html) or ([model =>, html =>])
        $model = null;
        $html = '';
        if (count($params) >= 2) {
            $model = $params[0];
            $html = $params[1] ?? '';
        } elseif (count($params) === 1 && is_array($params[0])) {
            $model = $params[0]['model'] ?? null;
            $html = $params[0]['html'] ?? '';
        } else {
            // Unknown payload shape; ignore safely
            return;
        }

        if (!$model) return;

        $this->$model = $html;
        $this->validateOnly($model, $this->rules(), $this->messages());
    }

    public function save()
    {
        $this->validate($this->rules(), $this->messages());
    
        try {
            if ($this->eventId) {
                // --- UPDATE ---
                $event = Event::findOrFail($this->eventId);
    
                // Only delete images that are not present in the new content
                $oldImages = $this->getImagesFromContent($event->article);
                $newImages = $this->getImagesFromContent($this->article);
                $imagesToDelete = array_diff($oldImages, $newImages);
                
                foreach ($imagesToDelete as $imageUrl) {
                    if (strpos($imageUrl, '/storage/rte-images/') !== false) {
                        $path = str_replace('/storage/', '', parse_url($imageUrl, PHP_URL_PATH));
                        Storage::disk('public')->delete($path);
                    }
                }
    
                // process new article (base64 → storage, swap src)
                $cleanHtml = $this->processQuillContent($this->article);
                $event->article = $cleanHtml;
    
                // other fields
                $event->title = $this->title;
                $event->description = $this->description;
                $event->event_date = $this->event_date;
                $event->tag = $this->tag;
                $event->is_highlighted = $this->is_highlighted;
    
                // thumbnail replacement
                if ($this->thumbnail) {
                    if ($event->thumbnail) {
                        Storage::disk('public')->delete($event->thumbnail);
                    }
                    $filename = uniqid() . '.' . $this->thumbnail->extension();
                    $this->thumbnail->storeAs('uploads/events', $filename, 'public');
                    $event->thumbnail = 'uploads/events/' . $filename;
                }
    
                $event->save();
                session()->flash('success', 'Event updated successfully!');
    
            } else {
                // --- CREATE ---
                $event = new Event();
                $event->title = $this->title;
                $event->description = $this->description;
                $event->event_date = $this->event_date;
                $event->tag = $this->tag;
                $event->is_highlighted = $this->is_highlighted;
    
                // process article
                $event->article = $this->processQuillContent($this->article);
    
                // handle thumbnail
                $filename = uniqid() . '.' . $this->thumbnail->extension();
                $this->thumbnail->storeAs('uploads/events', $filename, 'public');
                $event->thumbnail = 'uploads/events/' . $filename;
    
                $event->save();
                session()->flash('success', 'Event added successfully!');
            }
    
            return redirect()->route('admin.events');
        } catch (\Exception $e) {
            Log::error('Event save error: ' . $e->getMessage());
            session()->flash('error', 'Error saving event: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.events.event-form');
    }

    /*** Helpers ***/

    protected function processQuillContent(string $html): string
    {
        Storage::disk('public')->makeDirectory('rte-images');

        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        // Ensure UTF-8 handling for non-ASCII (e.g., Chinese) characters
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        foreach (iterator_to_array($dom->getElementsByTagName('img')) as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('#^data:image/([^;]+);base64,(.+)$#', $src, $m)) {
                $ext = $m[1];
                $data = base64_decode($m[2]);
                $filename = 'rte-images/' . uniqid() . '.' . $ext;
                Storage::disk('public')->put($filename, $data);
                $img->setAttribute('src', asset("storage/{$filename}"));
            }
        }

        $result = $dom->saveHTML();
        // Strip XML encoding preamble if present
        $result = preg_replace('/^<\?xml.*?\?>/u', '', $result);
        return $result;
    }

    protected function getImagesFromContent(string $html): array
    {
        preg_match_all('/<img[^>]+src="([^"]+)"/i', $html, $matches);
        return $matches[1] ?? [];
    }
}
