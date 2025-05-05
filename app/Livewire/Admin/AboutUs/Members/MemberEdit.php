<?php

namespace App\Livewire\Admin\AboutUs\Members;

use Livewire\Component;
use App\Models\Member;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MemberEdit extends Component
{
    use WithFileUploads;
    public $memberId;
    public $member;
    public $member_name;
    public $zh_member_name;
    public $position;
    public $zh_position;
    public $year;
    public $newPhoto;
    public $photo; // Add this to store the current photo path
    public $debugInfo = '';

    // Add this method to handle file uploads directly
    public function updatedNewPhoto()
    {
        $this->validate([
            'newPhoto' => 'image|max:5120', // 5MB max
        ]);
        
        $this->debugInfo = "Member photo uploaded: " . $this->newPhoto->getClientOriginalName();
    }

    // Change from property to method for dynamic rules
    protected function rules()
    {
        $rules = [
            'member_name' => 'required|string|max:255',
            'zh_member_name' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'zh_position' => 'nullable|string|max:255',
        ];

        // Only require photos for new records
        if (!$this->memberId) {
            $rules['newPhoto'] = 'required|image|max:5120';
        } else {
            $rules['newPhoto'] = 'nullable|image|max:5120';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'member_name.required' => 'The member name field is required.',
            'zh_member_name.required' => 'The member Chinese name field is required.',
            'position.required' => 'The position field is required.',
            'year.required' => 'The year field is required.',
            'newPhoto.required' => 'Please select a member photo to upload.',
            'newPhoto.image' => 'The file must be an image (jpeg, png, bmp, gif, svg, or webp).',
            'newPhoto.max' => 'The image size must not exceed 5MB.',
        ];
    }

    // Add this property
    public $availableYears = [];

    public function mount($memberId = null)
    {
        // Add this line to get available years
        $this->availableYears = \App\Models\AboutUs::pluck('year')->unique()->toArray();

        if ($memberId) {
            $this->memberId = $memberId;
            $this->member = Member::findOrFail($memberId);
            $this->member_name = $this->member->member_name;
            $this->zh_member_name = $this->member->zh_member_name;
            $this->position = $this->member->position;
            $this->zh_position = $this->member->zh_position;
            $this->year = $this->member->year;
            $this->photo = $this->member->photo; // Store the current photo path
        }
    }

    // Add validation on field update
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules(), $this->messages());
    }

    public $positions = [
        'Chairman' => '董事长',
        'Vice Chairman I' => '第一副董事长',
        'Vice Chairman II' => '第二副董事长',
        'Secretary' => '秘书长',
        'Treasurer' => '财政',
        'Supervision' => '监学',
        'Member of Board of Governor' => '董事'
    ];
    
    public function updatedPosition($value)
    {
        if (isset($this->positions[$value])) {
            $this->zh_position = $this->positions[$value];
        } else {
            $this->zh_position = '';
        }
    }

    public function save()
    {
        try {
            // Validate
            $this->validate($this->rules(), $this->messages());

            if ($this->memberId) {
                // Update existing member
                $member = Member::findOrFail($this->memberId);
            } else {
                // Create new member
                $member = new Member();
            }
            
            $member->member_name = $this->member_name;
            $member->zh_member_name = $this->zh_member_name;
            $member->position = $this->position;
            $member->zh_position = $this->zh_position;
            $member->year = $this->year;

            if ($this->newPhoto) {
                // Delete old photo if exists
                if ($member->photo) {
                    $imagePath = str_replace('public/', '', $member->photo);
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
                
                // Store the new photo
                $filename = uniqid() . '.' . $this->newPhoto->getClientOriginalExtension();
                $this->newPhoto->storeAs('uploads/members', $filename, 'public');
                $member->photo = 'uploads/members/' . $filename;
            }

            $member->save();
            
            $action = $this->memberId ? 'updated' : 'created';
            session()->flash('message', "Member '{$this->member_name}' {$action} successfully!");

            return redirect()->route('admin.aboutus.members.list');
        } catch (\Exception $e) {
            // Log error
            Log::error('Member save error: ' . $e->getMessage());
            
            // Update debug info
            $this->debugInfo .= "\nError: " . $e->getMessage();
            
            // Flash error message
            session()->flash('error', 'Error saving Member: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.aboutus.members.members-edit', [
            'debugInfo' => $this->debugInfo
        ]);
    }
}