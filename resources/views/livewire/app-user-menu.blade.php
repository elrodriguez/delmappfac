<div>
    <div>
        <a href="#" data-toggle="dropdown" title="{{ auth()->user()->email }}" class="header-icon d-flex align-items-center justify-content-center ml-2">
            @if(auth()->user()->profile_photo_path)
            <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" style="width:32px;height: 32px;" class="profile-image rounded-circle" alt="{{ auth()->user()->name }}">
            @else
            <img src="{{ ui_avatars_url(auth()->user()->name,32,'none') }}" style="width:32px;height: 32px;" class="profile-image rounded-circle" alt="{{ auth()->user()->name }}">
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
            <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
                <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
                    <span class="mr-2">
                        @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" style="width:50px;height: 50px;" class="rounded-circle profile-image" alt="{{ auth()->user()->name }}">
                        @else
                        <img src="{{ ui_avatars_url(auth()->user()->name) }}" style="width:50px;height: 50px;" class="rounded-circle profile-image" alt="{{ auth()->user()->name }}">
                        @endif
                    </span>
                    <div class="info-card-text">
                        <div class="fs-lg text-truncate text-truncate-lg">{{ auth()->user()->name }}</div>
                        <span class="text-truncate text-truncate-md opacity-80">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
            <div class="dropdown-divider m-0"></div>
            <a href="{{ route('profile.show') }}" class="dropdown-item">
                <span data-i18n="drpdwn.profile_show">@lang('messages.my_profile')</span>
            </a>
            @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="dropdown-divider m-0"></div>
                <h6 class="dropdown-header">@lang('messages.manage_team')</h6>
                <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="dropdown-item">
                    <span data-i18n="drpdwn.team_settings">@lang('messages.team_settings')</span>
                </a>
                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                    <a href="{{ route('teams.create') }}" class="dropdown-item">
                        <span data-i18n="drpdwn.create_new_team">@lang('messages.create_new_team')</span>
                    </a>
                @endcan

                <div class="dropdown-divider m-0"></div>
                <h6 class="dropdown-header">@lang('messages.switch_teams')</h6>
                @foreach (Auth::user()->allTeams() as $team)
                    <form method="POST" action="{{ route('current-team.update') }}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="team_id" value="{{ $team->id }}">
                        <a :component="$component" href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item {{ Auth::user()->isCurrentTeam($team)?'text-warning':'' }}">
                            @if (Auth::user()->isCurrentTeam($team))
                                <svg width="20px"  class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                            <span>{{ $team->name }}</span>
                        </a>
                    </form>
                @endforeach

            @endif
            <div class="dropdown-divider m-0"></div>
            @if (config('locale.status') && count(config('locale.languages')) > 1)
                <div class="dropdown-multilevel dropdown-multilevel-left">
                    <div class="dropdown-item">
                        @lang('messages.language')
                    </div>
                    <div class="dropdown-menu">
                    @foreach (array_keys(config('locale.languages')) as $lang)
                        @if ($lang != App::getLocale())
                            <a href="{{ route('lang.swap', $lang) }}" class="dropdown-item">
                                @if($lang == 'es')
                                    Español
                                @elseif($lang == 'en')
                                    English
                                @endif
                                <small>{{ $lang }}</small>
                            </a>
                        @endif
                    @endforeach
                    </div>
                </div>
            @endif
            <div class="dropdown-divider m-0"></div>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
            <a class="dropdown-item fw-500 pt-3 pb-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span data-i18n="drpdwn.page-logout">@lang('messages.logout')</span>
                <span class="float-right fw-n">&commat;{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>
    </div>
</div>
