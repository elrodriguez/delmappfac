<div>
    <div class="panel-container show">
        <div class="panel-content">
            <form wire:submit.prevent="newPermision()">
                <div class="form-row align-items-center">
                  <div class="col-4">
                    <label class="sr-only" for="new_permission">@lang('messages.new_permission')</label>
                    <input type="text" class="form-control mb-2" id="new_permission" wire:model="new_permission">

                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-2">@lang('messages.new_permission')</button>
                  </div>
                  @error('new_permission') <div class="col-auto"><span> {{ $message }}</span></div> @enderror
                </div>
            </form>
        </div>
        <form>
            <div class="panel-content">

                <div class="row">

                    @foreach($permissions as $index => $row)
                        <div class="col-6">
                            <div class="custom-control custom-checkbox" wire:ignore>
                                <input  wire:model="role_permissions.{{ $index }}" type="checkbox" class="custom-control-input" id="{{ $row->id  }}" value="{{ $row->id }}">
                                <label class="custom-control-label" for="{{ $row->id }}">{{ $row->name }}</label>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('roles') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
                <button class="btn btn-primary ml-auto waves-effect waves-themed" wire:loading.attr="disabled" type="button" wire:click="store">
                    <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                    <span>{{ __('messages.save') }}</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        window.addEventListener('response_permissions_role_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire('¡Enhorabuena!', msg, "success");
        }
    </script>
</div>
