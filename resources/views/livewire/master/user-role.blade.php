<div>
    <form class="needs-validation" novalidate>
        <div class="panel-content">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="form-group row">
                <label for="inputname" class="col-form-label col-12 col-lg-3 form-label text-lg-right">Roles</label>
                <div class="col-12 col-lg-6 " wire:ignore>
                    <select name="roles_user[]" id='roles_user' wire:model="roles_user" class='select2-placeholder-multiple form-control' multiple>
                        @foreach($roles as $key => $item)
                            <option value="{{ $item->id }}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('users') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="store({{ $id_user }})"><i class="fal fa-check mr-1"></i>Guardar</button>
        </div>
    </form>
    @section('script')
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            $("#roles_user").select2({
                placeholder: "Seleccione Rol"
            });
            $('.select2-placeholder-multiple').on('change', function (e) {
                var data = $('.select2-placeholder-multiple').select2("val");
                @this.set('roles_user', data);
            });
        });
        Livewire.hook('message.processed', (message, component) => {
            $("#roles_user").select2({
                placeholder: "Seleccione Rol"
            });
        }); 
    </script>
    @endsection
</div>