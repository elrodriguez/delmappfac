<div class="row">
    <div class="col-xl-12">
        <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
            Buscar comprobante electrónico
            <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                Todos los campos son requeridos para la búsqueda
            </small>
        </h2>
    </div>
    <div class="col-xl-6 ml-auto mr-auto">
        <div class="card p-4 rounded-plus bg-faded">
            <form id="js-login" novalidate="" action="intel_analytics_dashboard.html">
                <div class="form-group row">
                    
                    <div class="col-3">
                        <label class="form-label" for="document_type_id">@lang('messages.voucher_type')</label>
                        <select class="custom-select form-control" wire:change="changeSeries" wire:model.defer="document_type_id">

                            @foreach ($document_types as $document_type)
                            <option value="{{ $document_type->id }}">{{ $document_type->description }}</option>
                            @endforeach
                        </select>
                        @error('document_type_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <input type="text" id="lname" class="form-control" placeholder="Last Name" required>
                        <div class="invalid-feedback">No, you missed this one.</div>
                    </div>
                </div>
                <div class="row no-gutters">
                    <div class="col-md-4 ml-auto text-right">
                        <button id="js-login-btn" type="submit" class="btn btn-block btn-danger btn-lg mt-3">Send verification</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>