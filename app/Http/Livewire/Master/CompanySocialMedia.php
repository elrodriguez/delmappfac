<?php

namespace App\Http\Livewire\Master;

use App\Models\Master\SocialMedia;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CompanySocialMedia extends Component
{
    public $social_media_names;
    public $social_media_name_id;
    public $url_event;
    public $logo;
    public $background_color = '#3B5998';
    public $state = true;
    public $credentials = false;
    public $username;
    public $user_password;
    public $access_token;
    public $access_key_id;
    public $access_secret_key_id;
    public $access_port;
    public $access_host;
    public $access_api;
    public $social_medias = [];
    public $social_media_id;

    public $new = true;

    public function mount(){
        $this->social_media_names = get_enum_values('social_media','social_media_name');
    }

    public function render()
    {
        $this->social_medias = SocialMedia::all();
        return view('livewire.master.company-social-media');
    }

    public function store(){
        $this->validate([
            'social_media_name_id' => 'required',
            'url_event' => 'required|max:255',
            'logo' => 'required|max:255',
            'background_color' => 'required|max:255'
        ]);

        SocialMedia::create([
            'social_media_name' => $this->social_media_name_id,
            'url_event' => $this->url_event,
            'logo' => $this->logo,
            'background_color' => $this->background_color,
            'state' => $this->state,
            'credentials' => $this->credentials,
            'username' => $this->username,
            'user_password' => $this->user_password,
            'access_token' => $this->access_token,
            'access_key_id' => $this->access_key_id,
            'access_secret_key_id' => $this->access_secret_key_id,
            'access_port' => $this->access_port,
            'access_host' => $this->access_host,
            'access_api' => $this->access_api
        ]);

        $this->clearForm();
        $this->dispatchBrowserEvent('response_company_social_media_store', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function clearForm(){
        $this->new = true;
        $this->social_media_id = null;
        $this->url_event = null;
        $this->logo = null;
        $this->background_color = '#3B5998';
        $this->state = true;
        $this->credentials = false;
        $this->username = null;
        $this->user_password = null;
        $this->access_token = null;
        $this->access_key_id = null;
        $this->access_secret_key_id = null;
        $this->access_port = null;
        $this->access_host = null;
        $this->access_api = null;
    }

    public function edit($id){
        $this->new = false;
        $social_media = SocialMedia::find($id);
        $this->social_media_id = $social_media->id;
        $this->social_media_name_id = $social_media->social_media_name;
        $this->url_event = $social_media->url_event;
        $this->logo = $social_media->logo;
        $this->background_color = $social_media->background_color;
        $this->state = $social_media->state;
        $this->credentials = $social_media->credentials;
        $this->username = $social_media->username;
        $this->user_password = $social_media->user_password;
        $this->access_token = $social_media->access_token;
        $this->access_key_id = $social_media->access_key_id;
        $this->access_secret_key_id = $social_media->access_secret_key_id;
        $this->access_port = $social_media->access_port;
        $this->access_host = $social_media->access_host;
        $this->access_api = $social_media->access_api;
    }

    public function update(){

        $this->validate([
            'social_media_name_id' => 'required',
            'url_event' => 'required|max:255',
            'logo' => 'required|max:255',
            'background_color' => 'required|max:255'
        ]);

        SocialMedia::find($this->social_media_id)->update([
            'social_media_name' => $this->social_media_name_id,
            'url_event' => $this->url_event,
            'logo' => $this->logo,
            'background_color' => $this->background_color,
            'state' => $this->state,
            'credentials' => $this->credentials,
            'username' => $this->username,
            'user_password' => $this->user_password,
            'access_token' => $this->access_token,
            'access_key_id' => $this->access_key_id,
            'access_secret_key_id' => $this->access_secret_key_id,
            'access_port' => $this->access_port,
            'access_host' => $this->access_host,
            'access_api' => $this->access_api
        ]);

        $this->dispatchBrowserEvent('response_company_social_media_update', ['message' => Lang::get('messages.was_successfully_updated')]);
    }
}
