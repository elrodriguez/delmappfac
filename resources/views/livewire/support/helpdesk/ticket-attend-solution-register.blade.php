<div>
    <div id="panel-2" class="panel panel-sortable" data-panel-fullscreen="false" role="widget">
        <div class="panel-hdr" role="heading">
            <h2 class="ui-sortable-handle">{{ __('messages.register_solution') }}</h2>
        </div>
        <div class="panel-container show" role="content"><div class="loader"><i class="fal fa-spinner-third fa-spin-4x fs-xxl"></i></div>
            <div class="panel-content">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="closedok" name="closed" value="closed_ok" wire:model.defer="closed">
                    <label class="custom-control-label" for="closedok">{{ __('messages.closed_ok') }}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="closedfail" name="closed" value="closed_fail" wire:model.defer="closed">
                    <label class="custom-control-label" for="closedfail">{{ __('messages.closed_fail') }}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="cancel" name="closed" value="cancel" wire:model.defer="closed">
                    <label class="custom-control-label" for="cancel">{{ __('messages.cancel') }}</label>
                </div>
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 bg-faded">
                <textarea rows="3" class="form-control rounded-top border-bottom-left-radius-0 border-bottom-right-radius-0 border" wire:model.defer="solution" placeholder="{{ __('messages.write_solution') }}"></textarea>
                <div class="d-flex align-items-center py-2 px-2 bg-white border border-top-0 rounded-bottom">
                    <button id="attachment" type="button" class="btn btn-icon fs-lg waves-effect waves-themed">
                        <i class="fal fa-paperclip"></i>
                    </button>
                    <div class="ml-2" id="add_labels" wire:ignore></div>
                    <div class="custom-control custom-checkbox custom-control-inline ml-auto hidden-sm-down">
                        <input type="file" id="formFileSolution" style="display: none" wire:model.defer="file" accept="application/pdf">
                    </div>
                    <button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary btn-sm ml-auto ml-sm-0 waves-effect waves-themed">
                        {{ __('messages.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("attachment").addEventListener('click', function() {
            document.getElementById("formFileSolution").click();
        });
        document.getElementById("formFileSolution").addEventListener('change', function() {
            let pos = this.files.length - 1;
            document.getElementById("add_labels").innerHTML += `<div>${this.files[pos].name}<a onclick="deleteFileSolution()" href="javascript:void(0)" class="ml-2" title="Quitar Archivo"><i class="fal fa-times"></i></a></div>`;
        });
        function deleteFileSolution() {
            document.getElementById("formFileSolution").value = '';
            document.getElementById("add_labels").innerHTML = '';
        }

        window.addEventListener('response_success_ticket_solutions_store', event => {
            deleteFileSolution();
            swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
