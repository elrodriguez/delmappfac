<?php

namespace App\Http\Livewire\Logistics\Warehouse;

use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\Item;
use Livewire\Component;
use App\Models\Warehouse\Warehouse;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\ItemWarehouse;
use Carbon\Carbon;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class TranslateModalForm extends Component
{
    public $product_id;
    public $warehouse_id;
    public $destination_warehouse_id;
    public $quantity;
    public $quantity_move = 0;
    public $warehouses;
    public $warehouse_description;
    public $product_description;
    public $detail;

    public function render()
    {
        $this->warehouses = Warehouse::join('establishments','warehouses.establishment_id','establishments.id')
            ->select(
                'warehouses.id',
                'establishments.name',
                'warehouses.description'
            )
            ->get();

        $this->warehouse_name = Warehouse::where('id',$this->warehouse_id)->value('description');
        $this->product_description = Item::where('id',$this->product_id)->value('description');

        return view('livewire.logistics.warehouse.translate-modal-form');
    }

    public function store(){

        $this->validate([
            'product_id' => 'required',
            'warehouse_id' => 'required',
            'destination_warehouse_id' => 'required',
            'quantity' => 'required',
            'quantity_move' => 'required|numeric|between:0,99999999999.99',
            'detail' => 'required|min:4|max:255'
        ]);

        $pass = true;
        $title = '';
        $icon = '';
        $msg = '';

        if($this->quantity_move <= 0) {
            $pass = false;
            $title = 'Error';
            $icon = 'error';
            $msg = 'La cantidad a trasladar debe ser mayor a 0';
        }

        if($this->warehouse_id === $this->destination_warehouse_id) {
            $pass = false;
            $title = 'Error';
            $icon = 'error';
            $msg = 'El almacén destino no puede ser igual al de origen';
        }

        if($this->quantity < $this->quantity_move) {
            $pass = false;
            $title = 'Error';
            $icon = 'error';
            $msg = 'La cantidad a trasladar no puede ser mayor al que se tiene en el almacén.';
        }

        if($pass){
            $inventory = Inventory::create([
                'type' => 2,
                'description' => 'Traslado',
                'item_id' => $this->product_id,
                'warehouse_id' => $this->warehouse_id,
                'warehouse_destination_id' => $this->destination_warehouse_id,
                'quantity' => $this->quantity_move,
                'detail' => $this->detail
            ]);

            $itemwarehouse_destination = ItemWarehouse::where('item_id' ,'=', $this->product_id)
                ->where('warehouse_id' ,'=', $this->destination_warehouse_id)->first();

            if($itemwarehouse_destination){
                $itemwarehouse_destination->increment('stock',$this->quantity_move);
            }else{
                ItemWarehouse::create([
                    'item_id' => $this->product_id,
                    'warehouse_id' => $this->destination_warehouse_id,
                    'stock' => $this->quantity_move
                ]);
            }

            ItemWarehouse::where('item_id' ,'=', $this->product_id)
                ->where('warehouse_id' ,'=', $this->warehouse_id)
                ->decrement('stock', $this->quantity_move);

            InventoryKardex::create([
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'item_id' => $this->product_id,
                'inventory_kardexable_id' => $inventory->id,
                'inventory_kardexable_type' => Inventory::class,
                'warehouse_id' => $this->warehouse_id,
                'quantity'=> (-$this->quantity_move)
            ]);

            InventoryKardex::create([
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'item_id' => $this->product_id,
                'inventory_kardexable_id' => $inventory->id,
                'inventory_kardexable_type' => Inventory::class,
                'warehouse_id' => $this->destination_warehouse_id,
                'quantity'=> $this->quantity_move
            ]);

            $title = Lang::get('messages.congratulations');
            $icon = 'success';
            $msg = 'Producto trasladado con éxito';

            if($inventory){
                $user = Auth::user();
                $activity = new Activity;
                $activity->modelOn(Inventory::class,$inventory->id);
                $activity->causedBy($user);
                $activity->routeOn(route('logistics_warehouse_inventory_movements'));
                $activity->componentOn('logistics.warehouse.translate-modal-form');
                $activity->dataOld($inventory);
                $activity->logType('translate');
                $activity->log($msg);
                $activity->save();
            }

        }
        $this->dispatchBrowserEvent('response_translate_store', ['message' => $msg,'title'=> $title,'icon'=> $icon]);
    }
}
