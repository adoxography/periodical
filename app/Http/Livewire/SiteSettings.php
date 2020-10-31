<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use App\SiteSettings as Settings;
use Livewire\Component;

class SiteSettings extends Component
{
    public string $title;
    public string $description;

    public function mount(Settings $settings): void
    {
        $this->title = $settings->title;
        $this->description = $settings->description;
    }

    public function save(Settings $settings): void
    {
        $settings->title = $this->title;
        $settings->description = $this->description;
        $settings->save();
        $this->dispatchBrowserEvent('site-settings-updated');
    }

    public function render(): View
    {
        return view('livewire.site-settings');
    }
}
