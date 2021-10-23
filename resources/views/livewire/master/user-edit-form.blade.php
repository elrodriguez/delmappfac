<div>
    <form class="needs-validation" novalidate>
        <div class="panel-content">
            <div class="form-group row">
                <label for="establishment_id" class="col-form-label col-12 col-lg-3 form-label text-lg-right">{{ __('messages.establishment') }}</label>
                <div class="col-12 col-lg-6 ">
                    <select class="custom-select form-control" id="establishment_id" name="establishment_id" required="" wire:model.defer="establishment_id">
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
                <label for="inputname" class="col-form-label col-12 col-lg-3 form-label text-lg-right">{{ __('messages.name') }}</label>
                <div class="col-12 col-lg-6 ">
                    <input wire:model="name" type="text" name="name" class="form-control" id="inputname" placeholder="Nombre">
                    @error('name')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-form-label col-12 col-lg-3 form-label text-lg-right">{{ __('messages.email') }}</label>
                <div class="col-12 col-lg-6 ">
                    <input wire:model="email" type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                    @error('email')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-form-label col-12 col-lg-3 form-label text-lg-right">{{ __('messages.new_password') }}</label>
                <div class="col-12 col-lg-6">
                    <input wire:model="password" type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">

            <a href="{{ route('users') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="update"><i class="fal fa-check mr-1"></i>{{ __('messages.to_update') }}</button>
        </div>

    </form>
    <script defer>
        window.addEventListener('response_success_user', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
