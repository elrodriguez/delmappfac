<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>{{ __('messages.edit') }}</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="form-group" wire:ignore>
                    <label class="form-label" for="simpleinput">{{ __('messages.comment') }}</label>
                    <textarea id="editorcomment">
                        {{ htmlspecialchars_decode($comment_text, ENT_QUOTES) }}
                    </textarea>
                </div>
            </div>
            @if(auth()->user()->id == $comment_user_id)
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('subjects_courses_topic_forum_edit',[$course,$topic,$activity]) }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
                <button type="button" class="btn btn-primary ml-auto waves-effect waves-themed" onclick="updateComment()">
                    <span wire:loading wire:target="update" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" wire:loading.attr="disabled" class="fal fa-check mr-1" role="status" aria-hidden="true"></span>
                    <span>@lang('messages.to_update')</span>
                </button>
            </div>
            @endif
        </div>
    </div>
    <script>
        function updateComment(){
            let data = CKEDITOR.instances.editorcomment.getData();
            @this.set('comment_text', data);
            @this.update()
        }
        window.addEventListener('response_success_update_comment', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
