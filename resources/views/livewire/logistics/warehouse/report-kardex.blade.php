<div class="panel-container show">
    <div class="panel-content">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.product') }} <span class="text-danger">*</span> </label>
                <div wire:ignore>
                    <select name="item_id" id="select2-ajax" onchange="selectItem(event)"></select>
                </div>
                @error('item_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3 mb-3" wire:ignore>
                <label class="form-label">@lang('messages.date_start')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control " name="date_start" wire:model="date_start" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-1">
                    <div class="input-group-append">
                        <span class="input-group-text fs-xl">
                            <i class="fal fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3" wire:ignore>
                <label class="form-label">@lang('messages.date_end')<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" class="form-control " name="date_end" wire:model="date_end" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-2">
                    <div class="input-group-append">
                        <span class="input-group-text fs-xl">
                            <i class="fal fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                <button wire:click="updatingSearch" type="button" class="btn btn-primary ml-auto waves-effect waves-themed" wire:loading.attr="disabled" >
                    <span wire:loading wire:target="updatingSearch" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-search" class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                    <span>{{ __('messages.search') }}</span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
            <thead class="bg-primary-600">
                <tr>
                    <th>#</th>
                    <th>{{ __('messages.image') }}</th>
                    <th>{{ __('messages.product') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>Tipo transacción</th>
                    <th>{{ __('messages.number') }}</th>
                    <th>{{ __('messages.f_issuance') }}</th>
                    <th>{{ __('messages.entry_kardex') }}</th>
                    <th>{{ __('messages.exit_kardex') }}</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>
                        @php
                            $image_path = public_path('storage/items/'.$item->id.'.jpg');
                        @endphp
                        @if(file_exists($image_path))
                            <img src="{{ asset('storage/items/'.$item->id.'.jpg') }}" width=50px height=50px ></img>
                        @else
                            <img src="{{ ui_avatars_url($item->name,50,'none',0) }}" width=50px height=50px ></img>
                        @endif
                    </td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        @if ($item->inventory_kardexable_type == 'App\Models\Warehouse\Inventory')
                            {{ __('Stock inicial') }}
                        @elseif($item->inventory_kardexable_type == 'App\Models\Warehouse\Purchase')
                            @if ($item->quantity>0)
                                {{ __('Compra') }}
                            @else
                                {{ __('Anulación Compra') }}
                            @endif
                        @endif
                    </td>
                    <td>{{ $item->number }}</td>
                    <td>{{ $item->date_of_issue }}</td>
                    @if ($item->inventory_kardexable_type == 'App\Models\Warehouse\Inventory')
                        <td>{{ $item->quantity }}</td>
                        <td>-</td>
                    @elseif($item->inventory_kardexable_type == 'App\Models\Warehouse\Purchase')
                        @if ($item->quantity>0)
                            <td>{{ $item->quantity }}</td>
                            <td>-</td>
                        @else
                            <td>-</td>
                            <td>{{ $item->quantity }}</td>
                        @endif
                    @endif
                    @php
                        $balance = $balance + $item->quantity
                    @endphp
                    <td>{{ $balance }}</td>
                </tr>

                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10" class="text-right">{{ $items->links() }}</td>
                </tr>
            </tfoot>
        </table>

    </div>
    <script>
        function selectItem(e){
            @this.set('item_id', e.target.value);
        }
    </script>
</div>
