<div class="panel-container show">
    <div class="panel-content">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('messages.bank') }} <span class="text-danger">*</span></label>
                <select wire:model.defer="bank_id" class="custom-select form-control">
                    <option value="">{{ __('messages.to_select') }}</option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->description }}</option>
                    @endforeach
                </select>
                @error('bank_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">{{ __('messages.coin') }} <span class="text-danger">*</span></label>
                <select wire:model.defer="currency_type_id" class="custom-select form-control">
                    <option value="">{{ __('messages.to_select') }}</option>
                    @foreach ($currency_types as $currency_type)
                        <option value="{{ $currency_type->id }}">{{ $currency_type->description }}</option>
                    @endforeach
                </select>
                @error('currency_type_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span> </label>
                <input class="form-control" id="nadescriptionme" name="description" required="" wire:model.defer="description">
                @error('description')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('messages.number') }} <span class="text-danger">*</span> </label>
                <input class="form-control" id="number" name="number" required="" wire:model.defer="number">
                @error('number')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('messages.cci') }} <span class="text-danger">*</span> </label>
                <input class="form-control" id="cci" name="cci" required="" wire:model.defer="cci">
                @error('cci')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('messages.balance') }} <span class="text-danger">*</span> </label>
                <input class="form-control" id="initial_balance" name="initial_balance" required="" wire:model.defer="initial_balance">
                @error('initial_balance')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label">@lang('messages.state')</label>
                <div class="custom-control custom-checkbox">
                    <input wire:model.defer="state" type="checkbox" class="custom-control-input" id="defaultUnchecked">
                    <label class="custom-control-label" for="defaultUnchecked">@lang('messages.active')</label>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('configurations_master_bank_account') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
        <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:loading.attr="disabled" wire:click="update"><i class="fal fa-check mr-1"></i>{{ __('messages.to_update') }}</button>
    </div>

    <script>
        window.addEventListener('response_bank_account_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
