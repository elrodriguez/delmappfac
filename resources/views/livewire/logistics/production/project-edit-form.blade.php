<div class="panel-container show">
    <form id="formProjects" class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="description" name="description" required="" wire:model.defer="description">
                    @error('description')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3" wire:ignore>
                    <label class="form-label" for="select2-ajax">
                        @lang('messages.responsable_project')
                    </label>
                    <select data-placeholder="@lang('messages.select_state')" name="responsable_id" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectSupplier(event)">
                        <option value="{{ $responsable_name }}" selected="selected"></option>
                    </select>
                    @error('responsable_id')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3" wire:ignore>
                    <label class="form-label" for="select2-ajax">
                        @lang('messages.customer')
                    </label>
                    <select data-placeholder="@lang('messages.select_state')" name="person_customer_id" class="js-data-example-ajax form-control" id="select3-ajax"  onchange="selectCustomer(event)">
                        <option value="{{ $customer_name }}" selected="selected"></option>
                    </select>
                    @error('person_customer_id')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="budget">@lang('messages.budget')</label>
                    <input type="text" class="form-control" name="budget" wire:model.defer="budget">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="total_expenses">@lang('messages.total_expenses')</label>
                    <input type="text" class="form-control" name="total_expenses" wire:model.defer="total_expenses" disabled>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="datepicker-1">@lang('messages.date')</label>
                    <input type="text" class="form-control" id="datepicker-1" value="{{ $dates }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="text-state">@lang('messages.state')</label>
                    <select name="state_id" id="text-state" wire:model="state_id" class="custom-select form-control">
                        @foreach ($states as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3" wire:ignore>
                    <label class="form-label" for="country_id">@lang('messages.country_of_origin') <span class="text-danger">*</span></label>
                    <select class="custom-select form-control" id="country_id" name="country_id"  wire:model="country_id">
                        <option value>@lang('messages.to_select')</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->description }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3"  >
                    <label class="form-label" for="ubigeo">Ubigeo <span class="text-danger">*</span></label>
                    <div wire:ignore>
                        <select id="ubigeo" name="ubigeo" class="form-control" data="{{ $ubigeos }}" data-change="selectubigeo" data-default="{{ $ubigeo }}">
                        </select>
                    </div>
                    @error('ubigeo')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label" for="address">@lang('messages.address') <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="address" name="address" required="" wire:model.defer="address">
                    @error('address')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('logistics_production_projects') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="submit"><i class="fal fa-check mr-1"></i>{{ __('messages.save') }}</button>
        </div>
    </form>
    <script>
        function selectubigeo(e){
            @this.set('ubigeo', e);
        }
        function selectSupplier(e){
            @this.set('responsable_id', e.target.value);
        }
        function selectCustomer(e){
            @this.set('person_customer_id', e.target.value);
        }
        window.addEventListener('response_projects_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function datesSelects(start,end){
            @this.set('date_start', start);
            @this.set('date_end', end);
        }
    </script>
</div>
