<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
            @lang('messages.team_name') <span class="fw-300"><i>@lang('messages.msg_team_info')</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <form wire:submit.prevent="updateTeamName">
                <div class="panel-content">
                    <div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
                        <div class="d-inline-block align-middle status status-success mr-3">
                            <span class="profile-image rounded-circle d-block" style="background-image:url('{{ $team->owner->profile_photo_url }}'); background-size: cover;" alt="{{ $team->owner->name }}"></span>
                        </div>
                        <h5 class="mb-0 flex-1 text-dark fw-500">
                            {{ $team->owner->name }}
                            <small class="m-0 l-h-n">{{ $team->owner->email }}</small>
                        </h5>
                        <span class="text-muted fs-xs opacity-70">
                        @lang('messages.team_owner')
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">@lang('messages.team_name')</label>
                        <input id="name"
                            type="text"
                            class="form-control"
                            wire:model.defer="state.name"
                            :disabled="! Gate::check('update', $team)" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>
                @if (Gate::check('update', $team))
                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <x-jet-action-message class="mr-3" on="saved">
                        @lang('messages.saved')
                    </x-jet-action-message>
                    <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

