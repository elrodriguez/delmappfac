<div>
    <form class="needs-validation" novalidate>
        <div class="panel-content">
            <div class="form-group row">
                <label for="establishment_id" class="col-form-label col-12 col-lg-3 form-label text-lg-right">{{ __('messages.search_person') }}</label>
                <div class="col-12 col-lg-6 ">
                    <div class="input-group bg-white shadow-inset-2">
                        <div class="input-group-prepend" wire:ignore.self>
                            <span class="input-group-text bg-transparent border-right-0 py-1 px-3 text-success">
                                <i wire:loading wire:target="searchPersonDataBase" wire:loading.class="spinner-border spinner-border-sm" class="" role="status" aria-hidden="true"></i>
                                <i wire:loading.remove wire:target="searchPersonDataBase" class="fal fa-search"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control border-left-0 bg-transparent pl-0" wire:model.defer="number" id="number" name="number" placeholder="{{ __('messages.document_number') }}">
                        <div class="input-group-append">
                            <button wire:click="searchPersonDataBase" class="btn btn-default waves-effect waves-themed" type="button">¿{{ __('messages.exists') }}?</button>
                        </div>
					</div>
                    @error('number')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                    @if($error_num)
                        <div class="invalid-feedback-2">{{ $error_num }}</div>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="establishment_id" class="col-form-label col-12 col-lg-3 form-label text-lg-right">{{ __('messages.establishment') }}</label>
                <div class="col-12 col-lg-6 ">
                    <select {{ $this->disabled?'disabled':'' }} class="custom-select form-control" id="establishment_id" name="establishment_id" required="" wire:model.defer="establishment_id">
                        <option>{{ __('messages.to_select') }}</option>
                        @foreach ($establishments as $establishment)
                        <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                        @endforeach
                    </select>
                    @error('establishment_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="inputname" class="col-form-label col-12 col-lg-3 form-label text-lg-right">Nombre</label>
                <div class="col-12 col-lg-6 ">
                    <input {{ $this->disabled?'disabled':'' }} wire:model.defer="name" type="text" name="name" class="form-control" id="inputname" placeholder="Nombre">
                    @error('name')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-form-label col-12 col-lg-3 form-label text-lg-right">Email</label>
                <div class="col-12 col-lg-6 ">
                    <input {{ $this->disabled?'disabled':'' }} wire:model.defer="email" type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                    @error('email')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-form-label col-12 col-lg-3 form-label text-lg-right">Password</label>
                <div class="col-12 col-lg-6">
                    <input {{ $this->disabled?'disabled':'' }} wire:model.defer="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('users') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
            <button {{ $this->disabled?'disabled':'' }} class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="store">
                <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                <span>{{ __('messages.save') }}</span>
            </button>
        </div>
    </form>
    <script defer>
        window.addEventListener('response_success_user', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        window.addEventListener('response_search_message_person', event => {
            swalAlertInfo(event.detail.message);
        });
        function swalAlertInfo(msg){
            Swal.fire("Aviso", msg, "info");
        }
    </script>
</div>
