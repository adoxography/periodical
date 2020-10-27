<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserSettings extends Component
{
    use WithFileUploads;

    public User $user;
    public $image;

    protected $rules = [
        'user.name' => 'required|string',
        'user.email' => 'required|email',
        'user.bio' => 'nullable',

        'image' => 'nullable|image'
    ];

    public function save()
    {
        $data = $this->validate();

        if ($data['image']) {
            $this->user->avatar = $data['image']->store('/', $disk = 'images');
        }

        $this->user->save();
    }

    public function render()
    {
        return view('livewire.user-settings');
    }
}
