<?php

namespace App\Livewire\Admin\ContactUs;

use Livewire\Component;
use App\Models\ContactUs;

class ContactUsDisplay extends Component
{
    public $contactUs;

    public function mount()
    {
        $this->contactUs = ContactUs::first();
    }

    public function render()
    {
        return view('livewire.admin.contact-us.contact-us-display', [
            'contactUs' => $this->contactUs,
        ]);
    }
}
