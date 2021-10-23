<div>
    <form id="form-environment" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="soap_type_id">SOAP Tipo</label>
                    <select name="soap_type_id" id="soap_type_id" class="custom-select form-control">
                        @foreach ($soap_types as $soap_type)
                            <option value="{{ $soap_type->id }}">{{ $soap_type->description }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback-2 soap_type_id_err"></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="soap_type_id">SOAP Envio</label>
                    <select name="soap_send_id" class="custom-select form-control">
                        <option value="01">Sunat</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="soap_password">Contraseña</label>
                    <input name="soap_password" type="text" class="form-control" >
                    <span class="invalid-feedback-2 soap_password_err"></span>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="certificate">Certificado pfx</label>
                    <input name="certificate" type="file" class="form-control" id="certificate">
                    <span class="invalid-feedback-2 certificate_err"></span>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <button id="save-environment" onclick="saveEnvironment()" class="btn btn-primary ml-auto waves-effect waves-themed" type="button">
                <i class="fal fa-check mr-2"></i>{{ __('messages.save') }}
            </button>
        </div>
    </form>
    @if ($company->certificate)
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
            <table class="table table-striped m-0">
                <thead>
                    <tr>
                        <th>Archivo</th>
                        <th class="text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $company->certificate }}</td>
                        <td class="text-center">
                            <button wire:click="destroy" type="button" class="btn btn-xs btn-danger waves-effect waves-themed">{{ __('messages.delete') }}</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    <script defer>
        function saveEnvironment(){
            $('#save-environment').attr('disabled','disabled');
            let frm = document.getElementById('form-environment');
            let formData = new FormData(frm);
            $.ajax({
                url: "{{ route('company_uploadFile') }}",
                type:'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        let msg = data.success;
                        Swal.fire("Aviso", msg, "info");
                    }else{
                        printErrorMsg(data.error);
                    }
                    $('#save-environment').removeAttr('disabled');
                }
            });
        }

        function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {
              $('.'+key+'_err').text(value);
            });
        }
    </script>
</div>
