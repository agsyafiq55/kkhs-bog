<?php

namespace App\Livewire\Admin\AboutUs;

use Livewire\Component;
use App\Models\AboutUs;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use DOMDocument;

class AboutUsEdit extends Component
{
    use WithFileUploads;

    // Livewire Form
    public $aboutUsId;
    public $aboutUs;
    public $year;
    public $organization_photo;
    public $chairman_photo;
    public $chairman_speech;
    public $newOrganizationPhoto;
    public $newChairmanPhoto;
    public $debugInfo = '';

    protected function setContentAttribute($value)
    {
        $this->attributes['content'] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }

    // Listen for Quill editor updates
    protected $listeners = [
        'quillChanged' => 'updateQuill'
    ];

    protected function rules()
    {
        $rules = [
            'year' => 'required|string|max:9',
            'chairman_speech' => 'nullable|string',
        ];

        if (!$this->aboutUsId) {
            $rules['newOrganizationPhoto'] = 'required|image|max:5120';
            $rules['newChairmanPhoto'] = 'required|image|max:5120';
        } else {
            $rules['newOrganizationPhoto'] = 'nullable|image|max:5120';
            $rules['newChairmanPhoto'] = 'nullable|image|max:5120';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'year.required' => 'The year field is required.',
            'year.string' => 'The year must be a valid string.',
            'year.max' => 'The year cannot exceed 9 characters.',
            'newOrganizationPhoto.required' => 'Organization photo is required.',
            'newOrganizationPhoto.image' => 'Organization photo must be an image file.',
            'newOrganizationPhoto.max' => 'Organization photo must not exceed 5MB.',
            'newChairmanPhoto.required' => 'Chairman photo is required.',
            'newChairmanPhoto.image' => 'Chairman photo must be an image file.',
            'newChairmanPhoto.max' => 'Chairman photo must not exceed 5MB.',
        ];
    }

    public function mount($aboutUsId = null)
    {
        if ($aboutUsId) {
            $this->aboutUsId = $aboutUsId;
            $this->aboutUs = AboutUs::findOrFail($aboutUsId);
            $this->year = $this->aboutUs->year;
            $this->organization_photo = $this->aboutUs->organization_photo;
            $this->chairman_photo = $this->aboutUs->chairman_photo;
            $this->chairman_speech = $this->aboutUs->chairman_speech;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules(), $this->messages());
    }

    // Listener for Quill editor
    public function updateQuill($model, $html)
    {
        // Ensure UTF-8 encoding is preserved
        $html = mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html));
        
        // Remove any BOM if present
        $html = str_replace("\xEF\xBB\xBF", '', $html);
        
        // Force UTF-8 for DOMDocument operations
        $html = '<?xml encoding="UTF-8">' . $html;
        
        $this->$model = $html;
        $this->validateOnly($model, $this->rules(), $this->messages());
    }

    // Add this method to handle file uploads directly
    public function updatedNewOrganizationPhoto()
    {
        $this->validate([
            'newOrganizationPhoto' => 'image|max:5120', // 5MB max
        ]);
    }

    public function updatedNewChairmanPhoto()
    {
        $this->validate([
            'newChairmanPhoto' => 'image|max:5120', // 5MB max
        ]);
    }

    // Helper method to extract image URLs from HTML content
    protected function getImagesFromContent(string $html): array
    {
        $images = [];
        preg_match_all('/<img[^>]+src="([^"]+)"/i', $html, $matches);
        
        if (isset($matches[1])) {
            $images = $matches[1];
        }
        
        return $images;
    }

    // Process Quill content to save base64 images to storage
    protected function processQuillContent(string $html): string
    {
        Storage::disk('public')->makeDirectory('rte-images');

        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOENT);
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

        return $dom->saveHTML();
    }

    public function save()
    {
        $this->validate();
    
        try {
            if ($this->aboutUsId) {
                $aboutUs = AboutUs::findOrFail($this->aboutUsId);
                
                // Process chairman speech content
                if ($this->chairman_speech) {
                    // Only delete images that are not present in the new content
                    $oldImages = $this->getImagesFromContent($aboutUs->chairman_speech ?? '');
                    $newImages = $this->getImagesFromContent($this->chairman_speech);
                    $imagesToDelete = array_diff($oldImages, $newImages);
                    
                    foreach ($imagesToDelete as $imageUrl) {
                        if (strpos($imageUrl, '/storage/rte-images/') !== false) {
                            $path = str_replace('/storage/', '', parse_url($imageUrl, PHP_URL_PATH));
                            Storage::disk('public')->delete($path);
                        }
                    }
                    
                    // Process new content (base64 → storage, swap src)
                    $cleanHtml = $this->processQuillContent($this->chairman_speech);
                    $aboutUs->chairman_speech = $cleanHtml;
                }
                
                // Handle organization photo
                if ($this->newOrganizationPhoto) {
                    if ($aboutUs->organization_photo) {
                        Storage::disk('public')->delete($aboutUs->organization_photo);
                    }
                    $filename = uniqid() . '.' . $this->newOrganizationPhoto->getClientOriginalExtension();
                    $this->newOrganizationPhoto->storeAs('uploads/aboutus/organization_photo', $filename, 'public');
                    $aboutUs->organization_photo = 'uploads/aboutus/organization_photo/' . $filename;
                }
            
                // Handle chairman photo
                if ($this->newChairmanPhoto) {
                    if ($aboutUs->chairman_photo) {
                        Storage::disk('public')->delete($aboutUs->chairman_photo);
                    }
                    $filename = uniqid() . '.' . $this->newChairmanPhoto->getClientOriginalExtension();
                    $this->newChairmanPhoto->storeAs('uploads/aboutus/chairman_photo', $filename, 'public');
                    $aboutUs->chairman_photo = 'uploads/aboutus/chairman_photo/' . $filename;
                }

                $aboutUs->year = $this->year;
                $aboutUs->save();
            
                session()->flash('success', 'About Us information updated successfully.');
            } else {
                // Create new about us
                $aboutUs = new AboutUs();
                $aboutUs->year = $this->year;
                
                // Process chairman speech content for new entry
                if ($this->chairman_speech) {
                    $cleanHtml = $this->processQuillContent($this->chairman_speech);
                    $aboutUs->chairman_speech = $cleanHtml;
                }
            
                // Store organization photo
                $filename = uniqid() . '.' . $this->newOrganizationPhoto->getClientOriginalExtension();
                $this->newOrganizationPhoto->storeAs('uploads/aboutus/organization_photo', $filename, 'public');
                $aboutUs->organization_photo = 'uploads/aboutus/organization_photo/' . $filename;
            
                // Store chairman photo
                $filename = uniqid() . '.' . $this->newChairmanPhoto->getClientOriginalExtension();
                $this->newChairmanPhoto->storeAs('uploads/aboutus/chairman_photo', $filename, 'public');
                $aboutUs->chairman_photo = 'uploads/aboutus/chairman_photo/' . $filename;
            
                $aboutUs->save();
                session()->flash('success', 'About Us information created successfully.');
            }
        
            return redirect()->route('admin.aboutus');
        } catch (\Exception $e) {
            Log::error('Error saving about us: ' . $e->getMessage());
            session()->flash('error', 'Error saving about us information: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.aboutus.aboutus-edit', [
            'debugInfo' => $this->debugInfo
        ]);
    }
}