<div class="panel-container show">
    <form class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self >
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-4 mb-3" wire:ignore>
                    <label class="form-label" for="item_id">@lang('messages.item') <span class="text-danger">*</span> </label>
                    <select id="item_id" name="item_id" required="" class="form-control" wire:model="item_id" onchange="selectitem(event)">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->description }}</option>
                        @endforeach
                    </select>
                    @error('item_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="discount_id">@lang('messages.academic_discount') <span class="text-danger">*</span> </label>
                    <div class="input-group">
                        <select id="discount_id" name="discount_id" required="" class="custom-select form-control" wire:model="discount_id">
                            <option value="">{{ __('messages.to_select') }}</option>
                            @foreach ($discounts as $discount)
                                <option value="{{ $discount->id }}">{{ $discount->description }}</option>
                            @endforeach
                        </select>
                        <!--div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkmeout2" value="1" wire:model="general">
                                    <label class="custom-control-label" for="checkmeout2">{{ __('messages.general') }}</label>
                                </div>
                            </div>
                        </div-->
                    </div>
                    @error('discount_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">@lang('messages.date_payment') <span class="text-danger">*</span> </label>
                    <div class="input-group" wire:ignore.selef>
                        <input required="" type="text" class="form-control date-payment-input" wire:model="date_payment" name="date_payment" onchange="this.dispatchEvent(new InputEvent('input'))" >
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">@lang('messages.block_for_non-payment')</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultInline2" wire:model="to_block" name="to_block" value="1">
                        <label class="custom-control-label" for="defaultInline2">{{ __('messages.yes') }}</label>
                    </div>
                </div>
            </div>
            <div class="form-row justify-content-end">
                <div class="col-md-2 text-right mb-3">
                    <button wire:click="store()" type="button" class="btn btn-primary waves-effect waves-themed">{{ __('messages.add') }}</button>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline collapsed">
                    <thead class="bg-info-900">
                        <tr>
                            <th class="text-center">#</th>
                            <th>{{ __('messages.item') }}</th>
                            <th class="text-right">{{ __('messages.price') }}</th>
                            <th>{{ __('messages.academic_discount') }}</th>
                            <th class="text-right">{{ __('messages.percentage') }}</th>
                            <th class="text-center">{{ __('messages.date_payment') }}</th>
                            <th class="text-center">{{ __('messages.block') }}</th>
                            <th style="width: 160px" class="text-center">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($package_item_details)>0)
                            @php
                                $total = count($package_item_details);
                                $c = 1;
                            @endphp
                            @foreach ($package_item_details as $key => $package_item_detail)
                            <tr>
                                <th scope="row" class="text-center align-middle">{{ $key + 1 }}</th>
                                <td class="align-middle">{{ $package_item_detail['item_description'] }}</td>
                                <td class="text-right align-middle">{{ $package_item_detail['sale_unit_price'] }}</td>
                                <td class="align-middle">{{ $package_item_detail['discount_description'] }}</td>
                                <td class="text-right align-middle">{{ ($package_item_detail['percentage']?$package_item_detail['percentage']:0) }}%</td>
                                <td class="align-middle text-center">
                                    @if($package_item_detail['date_payment'])
                                    {{ \Carbon\Carbon::parse($package_item_detail['date_payment'])->format('d/m/Y') }}
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <div class="custom-control custom-switch">
										<input wire:change="changetoblock('{{ $package_item_detail['id'] }}','{{ $key }}')" type="checkbox" class="custom-control-input" id="customSwitch1{{ $package_item_detail['id'] }}" wire:model="package_item_details.{{ $key }}.to_block" name="package_item_details[{{ $key }}].to_block">
										<label class="custom-control-label" for="customSwitch1{{ $package_item_detail['id'] }}">{{ __('messages.yes') }}</label>
									</div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="btn-group mr-2" role="group" aria-label="Group A">
                                        @if($c > 1)
                                        <button wire:click="changeordernumber('1','{{ $package_item_detail['id'] }}','{{ $c }}','{{ $key }}')" type="button" class="btn btn-outline-secondary waves-effect waves-themed">
                                            <i class="fal fa-arrow-alt-up"></i>
                                        </button>
                                        @endif
                                        @if($total > $c)
                                        <button wire:click="changeordernumber('0','{{ $package_item_detail['id'] }}','{{ $c }}','{{ $key }}')" type="button" class="btn btn-outline-secondary waves-effect waves-themed">
                                            <i class="fal fa-arrow-alt-down"></i>
                                        </button>
                                        @endif
                                        <button wire:click="deleteItem('{{ $package_item_detail['id'] }}','{{ $c }}')" type="button" class="btn btn-secondary waves-effect waves-themed">
                                            <i class="fal fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $c++;
                            @endphp
                            @endforeach
                        @else
                        <tr class="odd">
                            <td colspan="8" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('academic_packages') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_add_items', event => {
            swalAlertSuccess(event.detail.message);
        });
        window.addEventListener('response_success_delete_items', event => {
            swalAlertError(event.detail.message);
        });
        function swalAlertSuccess(msg){
            Swal.fire("{{ __('messages.impossible_continue') }}", msg, "info");
        }
        function swalAlertError(msg){
            Swal.fire("{{ __('messages.impossible_continue') }}", msg, "error");
        }
        function selectitem(e){
            @this.set('item_id',e.target.value);
        }
    </script>
</div>
