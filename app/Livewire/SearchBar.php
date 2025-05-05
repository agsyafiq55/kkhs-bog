<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SearchBar extends Component
{
    public $query = '';
    public $model;
    public $searchFields = [];

    public $results = [];

    public function mount($model, $searchFields = ['name'])
    {
        $this->model = $model;
        $this->searchFields = $searchFields;
    }

    public function updatedQuery()
    {
        $this->search();
        $this->dispatch('searchUpdated', $this->query); 
    }


    public function search()
    {
        $modelClass = "App\\Models\\" . $this->model;

        $query = $modelClass::query();

        foreach ($this->searchFields as $field) {
            $query->orWhere($field, 'like', '%' . $this->query . '%');
        }

        $this->results = $query->take(5)->get();
        $this->dispatch('searchResults', $this->results); // Optional: notify parent
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
