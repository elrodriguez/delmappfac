<div>
    <div wire:ignore.self id="panel-compose" class="panel w-100 position-fixed pos-bottom pos-right mb-0 z-index-cloud mr-lg-4 shadow-3 border-bottom-left-radius-0 border-bottom-right-radius-0 expand-full-height-on-mobile expand-full-width-on-mobile shadow" style="max-width:40rem; height:35rem; display: none;">
        <div class="position-relative h-100 w-100 d-flex flex-column">
            <!-- desktop view -->
            <div class="panel-hdr bg-fusion-600 height-4 d-none d-sm-none d-lg-flex">
                <h4 class="flex-1 fs-lg color-white mb-0 pl-3">
                    {{ $title }}
                </h4>
                <div class="panel-toolbar pr-2">
                    <a href="javascript:void(0);" class="btn btn-icon btn-icon-light fs-xl mr-1" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen" data-placement="bottom">
                        <i class="fal fa-expand-alt"></i>
                    </a>
                    <a href="javascript:void(0);" id="btnCloseCompose" class="btn btn-icon btn-icon-light fs-xl" data-action="toggle" data-class="d-flex" data-target="#panel-compose" data-toggle="tooltip" data-original-title="Save & Close" data-placement="bottom">
                        <i class="fal fa-times"></i>
                    </a>
                </div>
            </div>
            <!-- end desktop view -->
            <!-- mobile view -->
            <div class="d-flex d-lg-none align-items-center px-3 py-3 bg-faded  border-faded border-top-0 border-left-0 border-right-0 flex-shrink-0">
                <!-- button for mobile -->
                <!-- end button for mobile -->
                <h3 class="subheader-title">
                    {{ $title }}
                </h3>
                <div class="ml-auto">
                    <button type="button" class="btn btn-outline-danger" data-action="toggle" data-class="d-flex" data-target="#panel-compose">Cancel</button>
                </div>
            </div>
            <!-- end mobile view -->
            <div class="panel-container show rounded-0 flex-1 d-flex flex-column">
                <div class="px-3">
                    <input wire:model.defer="email_to" type="text" placeholder="Recipients" class="form-control border-top-0 border-left-0 border-right-0 px-0 rounded-0 fs-md mt-2 pr-5" tabindex="2">
                    <a href="javascript:void(0)" class="position-absolute pos-right pos-top mt-3 mr-4" data-action="toggle" data-class="d-block" data-target="#message-to-cc" data-focus="message-to-cc" data-toggle="tooltip" data-original-title="Add Cc recipients" data-placement="bottom">Cc</a>
                    <input wire:model.defer="email_to_cc" type="text" placeholder="Cc" class="form-control border-top-0 border-left-0 border-right-0 px-0 rounded-0 fs-md mt-2 d-none" tabindex="3">
                    <input wire:model.defer="subject" type="text" placeholder="{{ __('messages.email_subject') }}" class="form-control border-top-0 border-left-0 border-right-0 px-0 rounded-0 fs-md mt-2" tabindex="4">
                    <div>
                        @error('email_to') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                        @error('subject') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="p-3">
                    <div wire:ignore>
                        <textarea class="js-summernote"></textarea>
                    </div>
                    <div>
                        @error('message_text') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="px-3 py-4 d-flex flex-row align-items-center flex-wrap flex-shrink-0">
                    <button wire:loading.remove wire:click="messageSend" type="button" class="btn btn-info waves-effect waves-themed mr-3">{{ __('messages.email_send') }}</button>
                    <button style="display: none" wire:loading wire:target="messageSend" class="btn btn-info waves-effect waves-themed mr-3" type="button" disabled="">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        {{ __('messages.sending') }}...
                    </button>
                    <a href="javascript:void(0);" class="btn btn-icon fs-xl mr-1" data-toggle="tooltip" data-original-title="Attach files" data-placement="top">
                        <i class="fas fa-paperclip color-fusion-300"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script defer>
        document.addEventListener('livewire:load', function () {
            $('.js-summernote').summernote({
                height: 200,
                tabsize: 2,
                dialogsFade: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks:{
                    onChange: function(contents, $editable){
                        @this.set('message_text',contents)
                    }
                }
            }); 
        });
        window.addEventListener('sho_load_message_default', event => {
            $(".js-summernote").summernote('code', event.detail.message);
        }); 
        window.addEventListener('response_contact_email_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            var objO = document.getElementById('btnCloseCompose');
            objO.click();
            $(".js-summernote").summernote('code',"");
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
