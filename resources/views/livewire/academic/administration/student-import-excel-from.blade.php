<div class="panel-container show">
    <div class="panel-content">
        <div class="panel-tag">
            el archivo debe tener la extencion <code>.xlsx</code> el orden de los registro debe ser:
            <ul>
                <li>Tipo documento(dni,pasaporte,otros)</li>
                <li>N&uacute;mero de documento</li>
                <li>Nombres</li>
                <li>Apellido Paterno</li>
                <li>Apellido Materno</li>
                <li>Dirección</li>
                <li>Email</li>
                <li>Telefono</li>
                <li>Género</li>
                <li>Fecha Nacimiento</li>
            </ul>
            <button class="btn btn-link" wire:click="exportExample" type="button">Descargar Ejemplo</button>
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
        <form method="POST" action="{{ route('academic_administration_students_import') }}" class="dropzone needsclick" style="min-height: 7rem;" enctype="multipart/form-data">
            @csrf
            <div class="dz-message needsclick">
                <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                <span class="text-uppercase">{{ __('messages.drop_files_here_or_click_to_upload') }}</span>
                <br>
                <span class="fs-sm text-muted">{{ __('messages.the_selected_files_are') }}</span>
            </div>
        </form>
        <div id="the-progress-div">
            <span class="the-progress-text"></span>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('academic_students') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
    </div>
</div>
