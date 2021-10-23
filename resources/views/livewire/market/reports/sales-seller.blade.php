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
                        <button wire:click="salesSeller" type="button" class="btn btn-primary ml-auto waves-effect waves-themed" >
                            <span class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                            <span>{{ __('messages.search') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div id="panel-2" class="panel">
                <div class="panel-hdr">
                    <h2>Total por Vendedor</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="dt-basic-example" class="table table-bordered table-striped w-100">
                                <thead class="bg-primary-600">
                                    <tr>
                                        <th>{{ __('messages.user') }}</th>
                                        <th class="text-right">{{ __('messages.total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($sales)>0)
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td>{{ $sale->name }}</td>
                                                <td class="text-right">{{ number_format($sale->sum, 2, ".", "") }}</td>
                                            </tr>
                                        @endforeach
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
        <div class="col-6">
            <div id="panel-2" class="panel">
                <div class="panel-hdr">
                    <h2>{{ __('messages.graph') }}</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div id="pieChart">
                            <canvas style="width:100%; height:300px;"></canvas>
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
        window.addEventListener('response_report_graph_sale', event => {
            loadChart(event.detail.graph);
        });
        function loadChart(graph){
            //dd = JSON.stringify(graph);
            console.log(graph.total)
            var config = {
                type: 'pie',
                data:
                {
                    datasets: [
                    {
                        data: graph.sum,
                        backgroundColor: [
                            color.primary._200,
                            color.primary._400,
                            color.success._400,
                            color.primary._100,
                            color.success._50,
                            color.primary._300,
                            color.success._500,
                            color.success._300,
                            color.primary._900,
                        ],
                        label: 'My dataset' // for legend
                    }],
                    labels: graph.name
                },
                options:
                {
                    responsive: true,
                    legend:
                    {
                        display: true,
                        position: 'bottom',
                    }
                }
            };
            new Chart($("#pieChart > canvas").get(0).getContext("2d"), config);
        }
    </script>
</div>
