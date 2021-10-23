<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Chat\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ContactList extends Component
{

    public function render()
    {
        $id = Auth::id();
        $team = Auth::user()->currentTeam->id;
        $contacts = [];
        $data_contact_members = DB::table('team_user')->join('users','team_user.user_id','users.id')
            ->where('team_user.team_id',$team)
            ->where('team_user.user_id','<>',$id)
            ->select('users.id','users.name','users.email','users.profile_photo_path')
            ->get();
        foreach($data_contact_members as $item){
            array_push($contacts,$item);
        }


        $data_contact_creator = DB::table('teams')->join('team_user','teams.id','team_user.team_id')
            ->join('users','teams.user_id','users.id')
            ->where('team_user.user_id','=',$id)
            ->where('teams.user_id','<>',$id)
            ->select('users.id','users.name','users.email','users.profile_photo_path')
            ->get();

        foreach($data_contact_creator as $item){
            array_push($contacts,$item);
        }
        return view('livewire.chat.contact-list',['contacts'=>$contacts]);
    }

    public function selectContact($name,$avatar,$user_id,$email){
        $id = Auth::id();
        $data_room = Room::where('room_index',$id.$user_id)
            ->orWhere('room_index',$user_id.$id)
            ->first();

        if($data_room){
            $data_inbox = [
                'id' => $user_id,
                'name' => $name,
                'email' => $email,
                'profile_photo_path' => $avatar,
                'room_id' => $data_room->id,
            ];
        }else{
            $data_inbox  = [
                'id' => $user_id,
                'name' => $name,
                'email' => $email,
                'profile_photo_path' => $avatar,
                'room_id' => 0,
            ];
        }

        $this->emit('messages-room-id',$data_inbox);
    }
}
