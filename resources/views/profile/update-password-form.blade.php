<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>@lang('messages.update_password')</h2>
        </div>
        <div class="panel-container show">
            <form wire:submit.prevent="updatePassword">
                <div class="panel-content">
                    <div class="panel-tag">
                        @lang('messages.msg_info_password')
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="current_password">@lang('messages.current_password')</label>
                        <input type="password" class="form-control" id="current_password" wire:model.defer="state.current_password">
                        @if($errors->has('current_password'))
                            <span>{{ $errors->first('current_password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">@lang('messages.new_password')</label>
                        <input type="password" class="form-control" id="password" wire:model.defer="state.password" >
                        @if($errors->has('password'))
                            <span>{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">@lang('messages.confirm_password')</label>
                        <input type="text" class="form-control" id="password_confirmation" wire:model.defer="state.password_confirmation">
                        @if($errors->has('password_confirmation'))
                            <span>{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
