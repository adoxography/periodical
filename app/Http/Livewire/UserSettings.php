<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserSettings extends Component
{
    use WithFileUploads;

    public User $user;

    /** @var UploadedFile */
    public $image;

    protected array $rules = [
        'user.name' => 'required|string',
        'user.email' => 'required|email',
        'user.bio' => 'nullable',

        'image' => 'nullable|image'
    ];

    public function save(): void
    {
        $data = $this->validate();

        if ($data['image']) {
            $this->user->avatar = $data['image']->store('/images');
        }

        $this->user->save();

        $this->dispatchBrowserEvent('user-settings-updated');
    }

    public function render(): View
    {
        return view('livewire.user-settings');
    }
}
