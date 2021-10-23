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

class RemoveModalForm extends Component
{
    public $product_id;
    public $warehouse_id;
    public $quantity;
    public $quantity_remove = 0;
    public $warehouse_description;
    public $product_description;
    public $detail;

    public function render()
    {
        $this->warehouse_name = Warehouse::where('id',$this->warehouse_id)->value('description');
        $this->product_description = Item::where('id',$this->product_id)->value('description');

        return view('livewire.logistics.warehouse.remove-modal-form');
    }

    public function remove(){
        $this->validate([
            'product_id' => 'required',
            'warehouse_id' => 'required',
            'quantity' => 'required',
            'quantity_remove' => 'required|numeric|between:0,99999999999.99'
        ]);

        $pass = true;
        $title = '';
        $icon = '';
        $msg = '';

        //Transaction
        $item_warehouse = ItemWarehouse::where('item_id', $this->product_id)
            ->where('warehouse_id', $this->warehouse_id)
            ->first();

        if(!$item_warehouse) {
            $pass = false;
            $title = 'Error';
            $icon = 'error';
            $msg = 'El producto no se encuentra en el almacén indicado.';
        }

        if($this->quantity < $this->quantity_remove) {
            $pass = false;
            $title = 'Error';
            $icon = 'error';
            $msg = 'La cantidad a retirar no puede ser mayor al que se tiene en el almacén.';
        }

        if($pass){
            $inventory = Inventory::create([
                'type' => 3,
                'description' => 'Retirar',
                'item_id' => $this->product_id,
                'warehouse_id' => $this->warehouse_id,
                'quantity' => $this->quantity_remove
            ]);

            ItemWarehouse::where('item_id' ,'=', $this->product_id)
                ->where('warehouse_id' ,'=', $this->warehouse_id)
                ->decrement('stock', $this->quantity_remove);

            InventoryKardex::create([
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'item_id' => $this->product_id,
                'inventory_kardexable_id' => $inventory->id,
                'inventory_kardexable_type' => Inventory::class,
                'warehouse_id' => $this->warehouse_id,
                'quantity'=> (-$this->quantity_remove)
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
                $activity->componentOn('logistics.warehouse.remove-modal-form');
                $activity->dataOld($inventory);
                $activity->logType('remove');
                $activity->log($msg);
                $activity->save();
            }

        }
        $this->dispatchBrowserEvent('response_remove_store', ['message' => $msg,'title'=> $title,'icon'=> $icon]);
    }
}
