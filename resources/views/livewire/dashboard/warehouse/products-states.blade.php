<div>
    <div id="panel-6" class="panel">
        <div class="panel-hdr">
            <h2>Transacciones por producto</h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div wire:ignore>
                    <select  data-placeholder="Buscar Producto" name="item_id" class="js-data-products-ajax form-control"  onchange="selectItem(event)"></select>
                </div>
            </div>
            <div class="panel-content p-0 mb-g">
                <div class="alert alert-success alert-dismissible fade show border-faded border-left-0 border-right-0 border-top-0 rounded-0 m-0" role="alert">
                    <strong>Total stock  <span>{{ number_format($stock_total, 2, '.', '') }}</span></strong>
                </div>
            </div>
            <div class="panel-content">
                <div class="row  mb-g">
                    <div class="col-md-12 col-lg-12 mr-lg-auto">
                        @foreach ($products as $product)
                            <div class="d-flex mt-2 mb-1 fs-xs text-primary">
                                {{ $product->description }}
                            </div>
                            @php
                                $porcentaje = ($product->total/$stock_total)*100;
                            @endphp
                            <div class="progress progress-xs mb-1" style="height: 1px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="progress progress-xs mb-3" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $porcentaje }}%;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($porcentaje, 2, '.', '') }}%</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectItem(e){
            let xid = e.target.value;
            @this.set('item_id',xid);
            @this.productsStock();
        }

    </script>
</div>
