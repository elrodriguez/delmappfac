<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>@lang('messages.search_filters')</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">@lang('messages.date')<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="custom-range">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" id="date_start" name="date_start">
                        <input type="hidden" id="date_end" name="date_end">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="warehouse" class="form-label">{{ __('messages.establishment') }}</label>
                        <select class="custom-select form-control" id="establishment_id" name="establishment_id" wire:model.defer="establishment_id">
                            <option value="">{{ __('messages.all') }}</option>
                            @foreach ($establishments as $establishment)
                                <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                        {{-- <button type="submit" class="btn btn-secondary ml-auto waves-effect waves-themed mr-3"><i class="fal fa-file-search mr-1"></i>{{ __('messages.excel') }}</button> --}}
                        <button wire:click="productSalesTop" type="button" class="btn btn-primary ml-auto waves-effect waves-themed" >
                            <span class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                            <span>{{ __('messages.search') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="panel-2" class="panel">
                <div class="panel-hdr">
                    <h2>{{ __('messages.products') }}</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="dt-basic-example" class="table table-striped table-bordered table-striped w-100">
                                <thead class="bg-primary-600">
                                    <tr>
                                        <th>{{ __('messages.name') }}</th>
                                        <th class="text-right">{{ __('messages.quantity') }}</th>
                                        <th class="text-right">{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($products)>0)

                                        @foreach ($products as $product)
                                            @php
                                                $amount = number_format((($product->amount/$graphlist['amount_total'])*100), 2, ".", "");
                                                $quantity = number_format((($product->quantity/$graphlist['quantity_total'])*100), 2, ".", "");
                                            @endphp
                                            <tr>
                                                <td class="align-middle">
                                                    @if($product->item)
                                                    {{ json_decode($product->item)->description }}
                                                    @endif
                                                    <div class="d-flex mt-2">
                                                        % Cantidad vendidos
                                                        <span class="d-inline-block ml-auto">{{ $quantity }} %</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-3">
                                                        <div class="progress-bar bg-fusion-400" role="progressbar" style="width: {{ $quantity }}%;" aria-valuenow="{{ $quantity }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="d-flex mt-2">
                                                        % Monto Acumulado
                                                        <span class="d-inline-block ml-auto">{{ $amount }} %</span>
                                                    </div>
                                                    <div class="progress progress-sm mb-3">
                                                        <div class="progress-bar bg-info-400" role="progressbar" style="width: {{ $amount }}%;" aria-valuenow="{{ $amount }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-right align-middle">{{ $product->quantity }}</td>
                                                <td class="text-right align-middle">{{ number_format($product->amount, 2, ".", "") }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="text-right align-middle">
                                                {{ __('messages.totals') }}
                                            </th>
                                            <th class="text-right align-middle">{{ $graphlist['quantity_total'] }}</th>
                                            <th class="text-right align-middle">{{ $graphlist['amount_total'] }}</th>
                                        </tr>

                                    @else
                                        <tr class="odd">
                                            <td colspan="10" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectDate(start,end){
            @this.set('date_start',start);
            @this.set('date_end',end);
        }

    </script>
</div>
