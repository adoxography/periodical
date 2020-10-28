<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SiteSettings extends Component
{
    public string $title;
    public string $description;

    public function mount(): void
    {
        $this->title = settings('title', '');
        $this->description = settings('description', '');
    }

    public function save(): void
    {
        settings()->put('title', $this->title);
        settings()->put('description', $this->description);
    }

    public function render()
    {
        return view('livewire.site-settings');
    }
}
