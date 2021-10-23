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
                    <div class="col-md-4 mb-3">
                        <label for="establishment_id" class="form-label">{{ __('messages.establishment') }}</label>
                        <select class="custom-select form-control" id="establishment_id" name="establishment_id" wire:model.defer="establishment_id">
                            <option value="">{{ __('messages.all') }}</option>
                            @foreach ($establishments as $establishment)
                                <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="warehouse" class="form-label">{{ __('messages.see') }}</label>
                        <select class="custom-select form-control" wire:model.defer="type">
                            <option value="sale">{{ __('messages.sold') }}</option>
                            <option value="nosale">{{ __('messages.no_sales') }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                        {{-- <button type="submit" class="btn btn-secondary ml-auto waves-effect waves-themed mr-3"><i class="fal fa-file-search mr-1"></i>{{ __('messages.excel') }}</button> --}}
                        <button wire:click="salesSearch" type="button" class="btn btn-primary ml-auto waves-effect waves-themed" >
                            <span class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                            <span>{{ __('messages.search') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($sales)>0)
        <div id="panel-2" class="panel">
            <div class="panel-hdr">
                <h2>@lang('messages.list')</h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content d-flex flex-row align-items-center">
                    <div class="">
                        <select class="custom-select form-control" wire:change="salesSearch" wire:model.defer="PRT007PAG">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                    <div class="ml-auto">{{ $sales->links() }}</div>
                </div>
                <div class="panel-content p-0">
                    <table id="dt-basic-example" class="m-0 table table-bordered table-striped">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>{{ __('messages.product') }}</th>
                                <th class="text-right">{{ __('messages.quantity') }}</th>
                                <th class="text-right">{{ __('messages.total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->description }}</td>
                                    <td class="text-right">{{ number_format($sale->quantity, 2, ".", "") }}</td>
                                    <td class="text-right">{{ number_format($sale->total, 2, ".", "") }}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="panel-content d-flex flex-row align-items-center">
                    <div class="">
                        <select class="custom-select form-control" wire:change="salesSearch" wire:model.defer="PRT007PAG">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                    <div class="ml-auto">{{ $sales->links() }}</div>
                </div>
            </div>
        </div>
    @elseif($alert)
        <div class="alert bg-info-400 text-white fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
            </button>
            <div class="d-flex align-items-center">
                <div class="alert-icon">
                    <i class="fal fa-info-circle"></i> 
                </div>
                <div class="flex-1">
                    <span class="h5">{{ __('messages.heads_up') }}</span> 	
                    <br>
                    {{ __('messages.no_data_available_in_the_table') }}
                </div>
            </div>
        </div>
    @endif
    <script>
        function selectDate(start,end){
            @this.set('date_start',start);
            @this.set('date_end',end);
        }
       
    </script>
</div>
