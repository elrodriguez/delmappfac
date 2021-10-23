<?php

namespace App\Http\Livewire\Master;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jenssegers\Agent\Agent;

class UserActivityLogDetails extends Component
{
    public $user_id;
    public $user;
    public $sessions;
    public $activities;
    public $date_start;
    public $date_end;

    public function mount($user_id){
        $this->user_id = $user_id;
        $this->date_start = Carbon::now()->format('Y-m-d');
        $this->date_end = Carbon::now()->format('Y-m-d');
    }
    public function render()
    {
        $this->user = User::find($this->user_id);

        $this->sessions = $this->getSessions();
        $this->getActivities();
        return view('livewire.master.user-activity-log-details');
    }

    private function getSessions(){

        return collect(
            DB::table('sessions')->where('user_id',$this->user_id)->get()
        )->map(function ($session) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => (object) [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    public function isDesktop($userAgent = null, $httpHeaders = null)
    {
        return !$this->isMobile($userAgent, $httpHeaders) && !$this->isTablet($userAgent, $httpHeaders) && !$this->isRobot($userAgent);
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function getActivities(){
        $activity = new \Elrod\UserActivity\Activity();
        $this->activities = $activity->getByUserAndDate($this->user_id,$this->date_start,$this->date_end);

    }
}
