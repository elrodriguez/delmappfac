<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                @lang('messages.list')
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div id="js_default_list" class="js-list-filter">
                    <div class="input-group mb-g">
                        <input wire:model.defer="table_name" type="text" class="form-control form-control-lg shadow-inset-2">
                        <select class="form-control form-control-lg" wire:model="table_level">
                            <option value="">Seleccionar</option>
                            <option value="1ro">1ro</option>
                            <option value="2do">2do</option>
                            <option value="3ro">3ro</option>
                            <option value="4to">4to</option>
                            <option value="5to">5to</option>
                        </select>
                        <div class="input-group-append">
                            <button wire:click="addTable()" class="btn btn-success waves-effect waves-themed" type="button" id="button-addon5"><i class="fal fa-plus mr-1"></i>@lang('messages.add')</button>
                        </div>
                    </div>
                    @error('table_name') <div class="col-auto"><span> {{ $message }}</span></div> @enderror
                    @error('table_level') <div class="col-auto"><span> {{ $message }}</span></div> @enderror
                    <ul class="list-group">
                        @php
                            $bg = '';
                        @endphp
                        @foreach($tables as $item)
                            @if($item->level == '1ro')
                                @php
                                    $bg = 'list-group-item-warning';
                                @endphp
                            @elseif($item->level == '2do')
                                @php
                                    $bg = 'list-group-item-info';
                                @endphp
                            @elseif($item->level == '3ro')
                                @php
                                    $bg = 'list-group-item-danger';
                                @endphp
                            @elseif($item->level == '4to')
                                @php
                                    $bg = 'list-group-item-success';
                                @endphp
                            @elseif($item->level == '5to')
                                @php
                                    $bg = 'list-group-item-primary';
                                @endphp
                            @endif
                            <li class="list-group-item {{ $bg }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $item->name }}</h5>
                                    <button wire:click="destroy('{{ $item->id }}')" type="button" class="btn btn-xs btn-danger waves-effect waves-themed">@lang('messages.delete')</button>
                                </div>
                                <h4 class="badge badge-secondary">{{ $item->level }}</h4>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
