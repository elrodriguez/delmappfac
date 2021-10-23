<div>
    <div class="panel-container show">
        <div class="panel-content">
            <form class="needs-validation" novalidate>
                <div class="panel-content">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="inputname" class="col-form-label col-12 col-lg-3 form-label text-lg-right">Nombre</label>
                        <div class="col-12 col-lg-6 ">
                            <input wire:model="name" type="text" name="name" class="form-control" id="inputname" placeholder="Nombre">
                            @error('name')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('roles') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="update({{ $id_rol }})"><i class="fal fa-check mr-1"></i>Guardar</button>
        </div>
    </div>
</div>
