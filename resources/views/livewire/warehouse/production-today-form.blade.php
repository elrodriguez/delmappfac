<div class="panel-container show">
    <form wire:submit.prevent="storeProduction" class="form-production-today needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate>
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="empresa">Marca</label>
                    <select required="" class="custom-select" name="empresa" id="empresa" wire:model="empresa">
                        <option value>@lang('messages.to_select')</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('empresa')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="producto">@lang('messages.container')</label>
                    <select required="" class="custom-select" name="producto" id="producto" wire:model.defer="producto">
                        @if($items)
                        <option value selected>@lang('messages.to_select')</option>
                        @else
                        <option value>Sin Datos</option>
                        @endif
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                        @endforeach
                    </select>
                    @error('producto')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="fecha">@lang('messages.date')</label>
                    <div class="input-group" wire:ignore>
                        <input required="" type="text" class="form-control" readonly="" wire:model="fecha" name="fecha" id="datepicker-3" onchange="this.dispatchEvent(new InputEvent('input'))">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    @error('fecha')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="pallets">Pallets</label>
                    <input wire:model.defer="pallets" name="pallets" type="text" class="form-control text-right" required="">
                    @error('pallets')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="filas">Filas</label>
                    <input wire:model.defer="filas" name="filas" type="text" class="form-control text-right" required="">
                    @error('filas')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="canastillas">Canastillas</label>
                    <input wire:model.defer="canastillas" name="canastillas" type="text" class="form-control text-right" required="">
                    @error('canastillas')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="cajas">Cajas</label>
                    <input wire:model.defer="cajas" name="cajas" type="text" class="form-control text-right" required="">
                    @error('cajas')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="unidades">Unidades</label>
                    <input wire:model.defer="unidades" name="unidades" type="text" class="form-control text-right" required="">
                    @error('unidades')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Cubetas</label>
                    <input wire:model.defer="cubetas" name="cubetas" type="text" class="form-control text-right">
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-4">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-default waves-effect waves-themed" type="button" wire:click="calculateTotal">Calcular Total<i class="fal fa-calculator ml-2"></i></button>
                        </div>
                        <input type="text" class="form-control text-right" name="total" wire:model.defer="total" readonly="" required="">
                    </div>
                    @error('total')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <button type="submit" class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-2"></i>@lang('messages.save')</button>
        </div>
    </form>
    <script defer>
        window.addEventListener('response_calculate_total', event => {
            swalAlertInfo(event.detail.message);
        });
        window.addEventListener('response_save_document_production', event => {
            swalAlertSuccess(event.detail.message);
        });
        window.addEventListener('response_validate_total_stock', event => {
            swalAlertError(event.detail.message);
        });
        function swalAlertInfo(msg){
            Swal.fire("", msg, "info");
        }
        function swalAlertSuccess(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function swalAlertError(msg){
            Swal.fire("{{ __('messages.error') }}", msg, "error");
        }
    </script>
</div>
