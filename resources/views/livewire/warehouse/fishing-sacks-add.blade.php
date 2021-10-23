<div class="panel-container show">
    <div class="panel-content">
        <table class="table table-bordered table-hover m-0">
            <thead class="thead-themed">
                <tr>
                    <th class="text-center">#</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.location') }}</th>
                    <th class="text-center">{{ __('messages.quantity') }} {{ __('messages.sacks') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fish as $key => $item)
                <tr>
                    <th scope="row" class="text-center align-middle">{{ $key+1 }}</th>
                    <td class="align-middle">{{ $item['fish_name'] }}</td>
                    <td class="align-middle">
                        <select name="fish[{{ $key }}].freezer_id" class="custom-select form-control" id="freezer{{ $key }}" wire:model.defer="fish.{{ $key }}.freezer_id">
                            <option>@lang('messages.to_select')</option>
                            @foreach ($freezers as $freezer)
                                <option value="{{ $freezer->id }}">{{ $freezer->name }}</option>
                            @endforeach
                        </select>
                        @error('fish.'.$key.'.freezer_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </td>
                    <td width="30%" class="align-middle">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text text-danger">
                                    20 kg. c/u.
                                </div>
                            </div>
                            <input type="text" class="form-control text-right" wire:model.defer="fish.{{ $key }}.sacks_quantity">
                            <div class="input-group-append">
                                <button class="btn btn-primary waves-effect waves-themed" type="button" wire:click="newSackProduced({{ $key }})"><i class="fal fa-check"></i></button>
                            </div>
                        </div>
                        @error('fish.'.$key.'.sacks_quantity')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('warehouse_fishing') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
        <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
    </div>
</div>
