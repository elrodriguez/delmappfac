<div class="panel-container show">
    <div class="panel-content">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">{{ __('messages.search_product') }}</label>
                    <div class="col-sm-9">
                        <div wire:ignore>
                            <input class="form-control basicAutoComplete" type="text"
                                data-url="{{ route('onlineshop_administration_promotions_items_search') }}"
                                autocomplete="off"
                            >
                        </div>
                        @error('item_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label text-right">{{ __('messages.price') }}</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" wire:model.defer="price">
                        @error('price')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <button wire:click="addItem" type="button" class="btn btn-primary mb-2">{{ __('messages.add') }}</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
						<thead class="bg-primary-600">
							<tr>
								<th>{{ __('messages.actions') }}</th>
								<th>{{ __('messages.description') }}</th>
								<th>{{ __('messages.price') }}</th>
							</tr>
						</thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td class="text-center align-middle">
                                    <button onclick="ondelete({{ $item->id }})" type="button" class="btn btn-danger btn-icon rounded-circle waves-effect waves-themed">
                                        <i class="fal fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td class="align-middle">{{ $item->description }}</td>
                                <td class="text-right align-middle">{{ number_format($item->price, 2, '.', '') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="2"> {{ __('messages.total') }}</td>
                                <td class="text-right">{{ number_format($total, 2, '.', '') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('onlineshop_administration_promotions') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
    </div>

    <script type="text/javascript">
        function selectItem(id){
            @this.set('item_id',id);
            @this.selectPrice(id);
        }

        function ondelete(id){
            Swal.fire({
                title: "{{ __('messages.are_you_sure') }}",
                text: "{{ __('messages.You_won_t_be_able_to_reverse_this') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.delete') }}",
                cancelButtonText: "{{ __('messages.cancel') }}"
            }).then(function(result){
                if (result.value)
                {
                    @this.destroy(id);
                }
            });
        }
        window.addEventListener('item_promotion_delete',() => {
            swalAlert();
        })
        function swalAlert(){
            Swal.fire("{{ __('messages.congratulations') }}","{{ __('messages.was_successfully_removed') }}", "success");
        }
    </script>
</div>
