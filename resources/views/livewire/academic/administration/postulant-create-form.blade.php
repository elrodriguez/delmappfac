<div>
    <form>
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Código modular </label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Resolución de licenciamiento y/o autorización <span class="text-danger">*</span> </label>
                    <select name="resolution_la" class="form-control">
                        @foreach ($resolutions as $resolution)
                            @if($resolution->id_resolution_type == 'RLA')
                            <option value="{{ $resolution->id }}">{{ $resolution->description }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Resolución de renovación y/o revalidación <span class="text-danger">*</span></label>
                    <select name="resolution_la" class="form-control">
                        @foreach ($resolutions as $resolution)
                            @if($resolution->id_resolution_type == 'RRR')
                            <option value="{{ $resolution->id }}">{{ $resolution->description }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Lugar donde se presta el servicio educativo <span class="text-danger">*</span> </label>
                    <select name="resolution_la" class="form-control">
                        <option value="">@lang('messages.to_select')</option>
                        @foreach ($establishments as $establishment)
                            <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Programa de estudios o carrera<span class="text-danger">*</span> </label>
                    <select name="resolution_la" class="form-control">
                        <option value="">@lang('messages.to_select')</option>
                        @foreach ($careers as $career)
                            <option value="{{ $career->id }}">{{ $career->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nivel formativo<span class="text-danger">*</span></label>
                    <select name="resolution_la" class="form-control">
                        <option value="">@lang('messages.to_select')</option>
                        @foreach ($traininglevels as $traininglevel)
                            <option value="{{ $traininglevel->id }}">{{ $traininglevel->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
            <h4>DATOS DEL POSTULANTE</h4>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">APELLIDO PATERNO <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">APELLIDO MATERNO <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">NOMBRES <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">DOMICILIO <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">TRABAJA<span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">PUESTO <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">ESTADO CIVIL <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">TELÉFONO<span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">CORREO ELECTRÓNICO <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">REGIÓN <span class="text-danger">*</span></label>
                    <select name="resolution_la" class="form-control">
                        <option value="">@lang('messages.to_select')</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">PROVINCIA <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">DISTRITO <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">DOCUMENTO DE IDENTIDAD TIPO <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">NUMERO<span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">LUGAR DE NACIMIENTO <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">SEXO <span class="text-danger">*</span></label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="example-fileinput">FOTO</label>
                <input type="file" id="example-fileinput" class="form-control-file">
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('postulants') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
        </div>
    </form>
</div>
