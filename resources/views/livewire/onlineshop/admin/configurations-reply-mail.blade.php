<div>
    @if($configuration)
    <div class="panel-content">
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-label" for="fixed_phone">{{ __('messages.message') }} <span class="text-danger">*</span> </label>
                <div wire:ignore>
                    <div class="js-summernote" id="saveToLocal">{!! $configuration->email_default !!}</div>
                </div>
                @error('email_default') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:loading.attr="disabled" wire:click="save"><i class="fal fa-check mr-1"></i>{{ __('messages.save') }}</button>
    </div>
    <script>
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
                        @this.set('email_default',contents)
                    }
                }
            }); 
        });
        window.addEventListener('response_configurations_reply_mail_save', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
    @endif
</div>
