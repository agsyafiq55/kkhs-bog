<?php

namespace App\Livewire\Public\ContactUs;

use Livewire\Component;
use App\Models\ContactUs;

class ContactUsList extends Component
{
    public $contactUs;

    public function mount()
    {
        $this->contactUs = ContactUs::first();
    }

    public function render()
    {
        return view('livewire.public.contact-us.contact-us-list');
    }
}