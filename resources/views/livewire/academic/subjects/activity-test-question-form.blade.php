<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>{{ __('messages.question') }}</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="form-group" wire:ignore>
                    <textarea id="questiontext">{!! $question_text !!}</textarea>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label for="question_type">{{ __('messages.type') }}</label>
                        <select wire:model.defer="question_type" name="question_type" class="custom-select form-control form-control-sm">
                            <option value="">{{ __('messages.to_select') }}</option>
                            <option value="radio">Una respuesta válida</option>
                            <option value="checkbox">Varias válidas</option>
                            <option value="text">Escribir respuesta</option>
                            <option value="file">Subir un archivo</option>
                        </select>
                        @error('question_type')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-2">
                        <label for="points">{{ __('messages.points') }}</label>
                        <input wire:model.defer="points" name="points" type="text" id="example-input-material" class="form-control form-control-sm text-center rounded-0 border-top-0 border-left-0 border-right-0 px-0 bg-transparent" placeholder="{{ __('messages.points') }}">
                        @error('points')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('subjects_courses_topic_test',[$course,$topic,$activity]) }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
                @if($question_id)
                <button type="button" class="btn btn-primary ml-auto waves-effect waves-themed" onclick="updateQuestion()">
                    <span wire:loading wire:target="update" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" wire:loading.attr="disabled" class="fal fa-check mr-1" role="status" aria-hidden="true"></span>
                    <span>@lang('messages.to_update')</span>
                </button>
                @else
                <button type="button" class="btn btn-primary ml-auto waves-effect waves-themed" onclick="saveQuestion()">
                    <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" wire:loading.attr="disabled" class="fal fa-check mr-1" role="status" aria-hidden="true"></span>
                    <span>@lang('messages.save')</span>
                </button>
                @endif
            </div>

        </div>
    </div>
    <script>
        function saveQuestion(){
            let data = CKEDITOR.instances.questiontext.getData();
            @this.set('question_text', data);
            @this.store()
        }
        function updateQuestion(){
            let data = CKEDITOR.instances.questiontext.getData();
            @this.set('question_text', data);
            @this.update()
        }
        window.addEventListener('response_success_activity_test_question_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            CKEDITOR.instances.questiontext.setData('');
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
