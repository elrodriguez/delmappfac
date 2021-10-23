<div>
    @role('SuperAdmin|Administrador')
    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-chart-area"></i> Pesquera <span class="fw-300">Dashboard</span>
        </h1>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{ $total_sacks->stock }}
                        <small class="m-0 l-h-n">Total de Sacos de 20 kg. c/u.</small>
                    </h3>
                </div>
                <i class="fal fa-ball-pile position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
            </div>
        </div>
        <!--div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        $10,203
                        <small class="m-0 l-h-n">Visual Index Figure</small>
                    </h3>
                </div>
                <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        - 103.72
                        <small class="m-0 l-h-n">Offset Balance Ratio</small>
                    </h3>
                </div>
                <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="p-3 bg-info-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        +40%
                        <small class="m-0 l-h-n">Product level increase</small>
                    </h3>
                </div>
                <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div-->
    </div>
    <!-- Distributed Series -->
    <div id="panel-20" class="panel">
        <div class="panel-hdr">
            <h2>
                @lang('messages.packaging') <span class="fw-300"><i>@lang('messages.production') </i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="panel-tag">
                    gráfica comparativa del total general de envases producidos
                </div>
                <div id="distributedSeries" class="ct-chart" style="width:100%; height:300px;"></div>
            </div>
        </div>
    </div>
    <script defer>
        var distributedSeries = function(){
                new Chartist.Bar('#distributedSeries',
                {
                    labels: [
                        @php
                            foreach($boxes as $box){
                                echo "'".$box->name.'\n'.$box->description."',";
                            }
                        @endphp
                    ],
                    series: [
                        @php
                            foreach($boxes as $box){
                                echo "'".$box->stock."',";
                            }
                        @endphp
                    ]
                },
                {
                    distributeSeries: true
                });
        }

    </script>
    @endrole
</div>
