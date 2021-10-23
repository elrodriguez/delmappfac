<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Support\Facades\Auth;

class ShowInfoUserAvatar extends Component
{
    use WithFileUploads;

    public $photo;
    public $state = [];

    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
    }

    
    public function render()
    {
        return view('livewire.show-info-user-avatar');
    }

    public function updateImagePhoto(UpdatesUserProfileInformation $updater){
        $updater->update(
            Auth::user(),array_merge($this->state, ['photo' => $this->photo])
        );
    }
    public function deleteProfileAvatar()
    {
        $user = Auth::user();
        $user->profile_photo_path = null;
        $user->save();
    }
}
