<div>
    <div class="px-3 px-sm-5 pt-4">
        <div class="input-group input-group-lg mb-5 shadow-1 rounded">
            <input type="text" class="form-control shadow-inset-2" wire:model.defer="search" id="filter-icon" aria-label="type 2 or more letters" >
            <div class="input-group-append">
                <button class="btn btn-primary hidden-sm-down" type="button" wire:click="updatingSearch()" ><i class="fal fa-search mr-lg-2"></i><span class="hidden-md-down">@lang('messages.search')</span></button>
                <button class="btn btn-success hidden-sm-down" type="button" onclick="showModalParamter()"><i class="fal fa-plus mr-lg-2"></i><span class="hidden-md-down">@lang('messages.new')</span></button>
            </div>
        </div>
    </div>
    <div class="px-3 px-sm-5 pb-4">

        <div class="card">
            <ul class="list-group list-group-flush">
                @foreach ($parameters as $key => $item)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <label class="form-label"><code>{{ $item->id_parameter }}</code> {{ $item->description }}</label>
                                <div class="d-flex flex-row align-items-center">
                                    @if($item->type == 1)
                                        <div class="mr-3">
                                            <input type="text" class="form-control col-4" wire:model.defer="value_default.{{ $key }}">
                                        </div>
                                        <button class="btn btn-primary btn-sm ml-auto waves-effect waves-themed" id="btnsaveparameters{{ $key }}" type="button" wire:loading.attr="disabled" wire:click="changeValueDefaultSave('{{ $item->id }}','{{ $key }}')"><i class="fal fa-check"></i></button>
                                    @elseif($item->type == 2)
                                        @php
                                            $arrs = explode('|',$item->code_sql);
                                        @endphp
                                        <select class="custom-select form-control col-4" wire:model="value_default.{{ $key }}" wire:change="changeValueDefaultSave('{{ $item->id }}','{{ $key }}')">
                                            @foreach ($arrs as $arr)
                                                @php
                                                    list($index,$text) = explode(',',$arr);
                                                @endphp
                                            <option value="{{ $index }}">{{ $text }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($item->type == 3)
                                        <select class="custom-select form-control col-4">
                                            <option>de re</option>
                                        </select>
                                    @elseif($item->type == 4)
                                        <div class="demo">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="defaultUncheckedRadio" name="defaultExampleRadios">
                                                <label class="custom-control-label" for="defaultUncheckedRadio">Unchecked</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="defaultCheckedRadio" name="defaultExampleRadios" checked="">
                                                <label class="custom-control-label" for="defaultCheckedRadio">Checked</label>
                                            </div>
                                        </div>
                                    @elseif($item->type == 5)
                                        @php
                                            $arrs_k = explode('|',$item->code_sql);
                                        @endphp
                                        <div class="demo mr-3" wire:ignore>
                                            @foreach ($arrs_k as $k => $arr)
                                                @php
                                                    list($index,$text) = explode(',',$arr);
                                                @endphp
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="defaultUnchecked{{ $key.$k.$index }}" wire:model.defer="value_default.{{ $key }}" value="{{ $index }}">
                                                    <label class="custom-control-label" for="defaultUnchecked{{ $key.$k.$index }}">{{ $text }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="btn btn-primary btn-sm ml-auto waves-effect waves-themed mt-3" id="btnsaveparameters{{ $key }}" type="button" wire:loading.attr="disabled" wire:click="changeValueDefaultSave('{{ $item->id }}','{{ $key }}')"><i class="fal fa-check"></i></button>
                                    @elseif($item->type == 6)
                                        <div class="demo">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                                <label class="custom-control-label" for="defaultUnchecked">Unchecked</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="defaultChecked" checked="">
                                                <label class="custom-control-label" for="defaultChecked">Checked</label>
                                            </div>
                                        </div>
                                    @elseif($item->type == 7)
                                        <div class="demo">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="defaultUnchecked">
                                                <label class="custom-control-label" for="defaultUnchecked">Unchecked</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="defaultChecked" checked="">
                                                <label class="custom-control-label" for="defaultChecked">Checked</label>
                                            </div>
                                        </div>
                                    @elseif($item->type == 8)
                                        <textarea class="form-control mr-3" wire:model.defer="value_default.{{ $key }}"></textarea>
                                        <button class="btn btn-primary btn-sm ml-auto waves-effect waves-themed" id="btnsaveparameters{{ $key }}" type="button" wire:loading.attr="disabled" wire:click="changeValueDefaultSave('{{ $item->id }}','{{ $key }}')"><i class="fal fa-check"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <span onclick="showModalParamterEdit('{{ $item->id }}')" style="cursor: pointer;" class="badge badge-primary badge-pill float-right">@lang('messages.edit')</span>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="card-footer">
                {{ $parameters->links() }}
            </div>
        </div>

    </div>
    <script>
        window.addEventListener('response_parameter_value_default_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function reloadList(){
            @this.resetPage();
        }
    </script>
</div>
