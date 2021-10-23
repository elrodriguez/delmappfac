<div class="panel-container show">
    <div class="panel-content">
        <div class="panel-tag">
            el archivo debe tener la extencion <code>.xlsx</code> el orden de los registro debe ser:
            <ul>
                <li>{{ __('messages.type') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.code') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.measure') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.name') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.description') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.stock_min') }} </li>
                <li>{{ __('messages.stock') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.brand') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.category') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.price_purchase') }}<span class="text-danger ml-1">*</span></li>
                <li>{{ __('messages.price_sale') }}<span class="text-danger ml-1">*</span></li>
                {{-- <li>digemid<span class="fw-300 font-italic ml-1">(Opcional)</span></li>
                <li>Nombre corto<span class="fw-300 font-italic ml-1">(Opcional)</span></li> --}}
            </ul>
            <a class="btn btn-link" href="{{ asset('storage/rrhh/example/employees.xlsx') }}">Descargar Ejemplo</a>
        </div>
        @if ( $errors->any() )

            <div class="alert alert-danger">
                @foreach( $errors->all() as $error )<li>{{ $error }}</li>@endforeach
            </div>
        @endif

        @if(isset($numRows))
            <div class="alert alert-sucess">
                Se importaron {{$numRows}} registros.
            </div>
        @endif
        <form method="POST" action="{{ route('logistics_catalogs_products_import') }}" class="dropzone needsclick" style="min-height: 7rem;" enctype="multipart/form-data">
            @csrf
            <div class="dz-message needsclick">
                <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                <span class="text-uppercase">{{ __('messages.drop_files_here_or_click_to_upload') }}</span>
                <br>
                <span class="fs-sm text-muted">{{ __('messages.the_selected_files_are') }}</span>
            </div>
        </form>

    </div>
    <div class="progress">
        <div class="progress-bar progress-bar-primary" role="progressbar" data-dz-uploadprogress>
            <span class="progress-text"></span>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('logistics_catalogs_products') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
    </div>
</div>
