<div class="card-columns">

    @foreach($images as $image)
        <div class="card">
            <img src="{{ url('storage/'.$image->url) }}" class="card-img-top" alt="{{ $image->name }}">
            <div class="card-body">
                <p class="card-text">{{ $image->name }}</p>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div class="p-2">
                        <button wire:click="activeImage({{ $image->id }})" class="btn btn-info btn-icon rounded-circle waves-effect waves-themed" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Activar o Desactivar">
                            @if($image->state)
                            <i class="fal fa-times"></i>
                            @else
                            <i class="fal fa-check"></i>
                            @endif
                        </button>
                    </div>
                    <div class="p-2">
                        <button wire:click="principalImage({{ $image->id }})" class="btn btn-success btn-icon rounded-circle waves-effect waves-themed" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imagen principal">
                            @if($image->principal)
                            <i class="fal fa-lightbulb-slash"></i>
                            @else
                            <i class="fal fa-lightbulb-on"></i>
                            @endif
                        </button>
                    </div>
                    <div class="p-2">
                        <button wire:click="destroy({{ $image->id }})" class="btn btn-danger btn-icon rounded-circle waves-effect waves-themed" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Eliminar imagen"><i class="fal fa-trash-alt"></i></button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
