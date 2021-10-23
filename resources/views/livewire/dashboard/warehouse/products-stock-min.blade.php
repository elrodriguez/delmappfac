<div>
    <div id="panel-6" class="panel">
        <div class="panel-hdr">
            <h2>Producto por Terminarse</h2>
        </div>
        <div class="panel-container show">
            <div class="panel-content p-0">
                <div class="">
                    <table class="table">
                        <thead class="bg-warning-200">
                            <tr>
                                <th class="text-center align-middle">#</th>
                                <th class="text-center align-middle">{{ __('messages.image') }}</th>
                                <th class="align-middle">{{ __('messages.code') }}</th>
                                <th class="align-middle">{{ __('messages.description') }}</th>
                                <th class="text-center align-middle">{{ __('messages.stock') }}</th>
                                <th class="text-center align-middle">{{ __('messages.stock_min') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                    <td class="text-center align-middle">
                                        <img src="{{ asset('storage/items/'.$product->id.'.jpg') }}" alt="{{ $product->description }}" style="width: 54px">
                                    </td>
                                    <td class="align-middle">{{ $product->internal_id }}</td>
                                    <td class="align-middle">{{ $product->description }}</td>
                                    <td class="text-right align-middle">
                                        @if ($product->stock == $product->stock_min)
                                            <span class="text-warning">{{ number_format($product->stock, 2, '.', '') }}</span>
                                        @else
                                            <span class="text-danger">{{ number_format($product->stock, 2, '.', '') }}</span>
                                        @endif

                                    </td>
                                    <td class="text-right align-middle">{{ $product->stock_min }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
