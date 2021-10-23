<div>
    <div class="row">
        <div class="col mb-2">
            <label class="sr-only" for="warehouse_id">Empresa</label>
            <select required="" class="form-control" name="warehouse_id" id="warehouse_id" wire:model="warehouse_id" wire:change="materialslistChangeSelect">
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col mb-2">
            <label for="inputPassword2" class="sr-only">@lang('messages.product')</label>
            <select class="form-control" name="item_id" id="item_id" wire:model.defer="item_id" wire:change="materialslist">
                @if($items)
                <option value selected>@lang('messages.to_select')</option>
                @else
                <option value>Sin Datos</option>
                @endif
                @foreach ($items as $item)
                    <option value="{{ $item->id }}" style="background:url({{asset('storage/items/'.$item->id.'.jpg')}}) no-repeat center left; padding-left:20px;">
                        {{ $item->description }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-2 mb-2">
            <button type="button" class="btn btn-primary mb-2" wire:click="materialslist()">@lang('messages.search')</button>
        </div>
    </div>
    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
        <thead class="bg-primary-600">
            <tr>
                <th width="10%">@lang('messages.image')</th>
                <th width="15%">@lang('messages.code')</th>
                <th width="20%">@lang('messages.brand')</th>
                <th width="40%">@lang('messages.product')</th>
                <th width="15%"class="text-right">Stock </th>
            </tr>
        </thead>
        <tbody>
            @if($materials)
                @foreach ($materials as $material)
                    <tr>
                        <td><img src="{{ asset('storage/items/'.$material->id.'.jpg')}}" width=50px height=50px /></td>
                        <td>{{ $material->item_code }}</td>
                        <td>{{ $material->name }}</td>
                        <td>{{ $material->description }}</td>
                        <td class="text-right">{{ $material->stock }}</td>
                    </tr>
                @endforeach
            @else
                <tr class="odd">
                    <td colspan="5" class="dataTables_empty text-center" valign="top">@lang('messages.no_data_available')</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
