<?php

namespace App\Http\Livewire\Logistics\Warehouse;

use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\InventoryTransaction;
use App\Models\Warehouse\ItemWarehouse;
use App\Models\Warehouse\Warehouse;
use Carbon\Carbon;
use Livewire\Component;
use Elrod\UserActivity\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class MovementsModalForm extends Component
{
    public $type;
    public $product_id;
    public $warehouses;
    public $warehouse_id;
    public $transactions;
    public $transaction_id;
    public $quantity = 0;

    public function render()
    {
        $this->warehouses = Warehouse::join('establishments','warehouses.establishment_id','establishments.id')
            ->select(
                'warehouses.id',
                'establishments.name',
                'warehouses.description'
            )
            ->get();
        if($this->type == 'i'){
            $this->transactions = InventoryTransaction::where('types','input')
                ->get();
        }else{
            $this->transactions = InventoryTransaction::where('types','output')
                ->get();
        }

        return view('livewire.logistics.warehouse.movements-modal-form');
    }

    public function store(){
        $this->validate([
            'product_id' => 'required',
            'warehouse_id' => 'required',
            'transaction_id' => 'required',
            'quantity' => 'required|numeric|between:0,99999999999.99'
        ]);

        $item_warehouse = ItemWarehouse::firstOrNew([
            'item_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id
        ]);

        $inventory_transaction = InventoryTransaction::findOrFail($this->transaction_id);

        $msg = '';
        $title = '';
        $icon = '';
        $inventory = [];

        if($this->type == 's'){
            if($this->quantity > $item_warehouse->stock) {
                $icon = 'error';
                $title = 'Error';
                $msg = 'La cantidad no puede ser mayor a la que se tiene en el almacén.';
            }else{
                $inventory = Inventory::create([
                    'type' => null,
                    'description' => $inventory_transaction->description,
                    'item_id'=> $this->product_id,
                    'warehouse_id' => $this->warehouse_id,
                    'quantity' => $this->quantity,
                    'inventory_transaction_id' => $this->transaction_id
                ]);

                ItemWarehouse::where('item_id' ,'=', $this->product_id)
                    ->where('warehouse_id' ,'=', $this->warehouse_id)
                    ->decrement('stock',$this->quantity);

                InventoryKardex::create([
                    'date_of_issue' => Carbon::now()->format('Y-m-d'),
                    'item_id' => $this->product_id,
                    'inventory_kardexable_id' => $inventory->id,
                    'inventory_kardexable_type' => Inventory::class,
                    'warehouse_id' => $this->warehouse_id,
                    'quantity'=> (-$this->quantity)
                ]);

                $icon = 'success';
                $title = Lang::get('messages.congratulations');
                $msg = 'Salida registrada correctamente';
            }
        }else{
            $inventory = Inventory::create([
                'type' => null,
                'description' => $inventory_transaction->description,
                'item_id'=> $this->product_id,
                'warehouse_id' => $this->warehouse_id,
                'quantity' => $this->quantity,
                'inventory_transaction_id' => $this->transaction_id
            ]);

            $itemwarehouse = ItemWarehouse::where('item_id' ,'=', $this->product_id)
                ->where('warehouse_id' ,'=', $this->warehouse_id)->first();
            if($itemwarehouse){
                $itemwarehouse->increment('stock',$this->quantity);
            }else{
                ItemWarehouse::create([
                    'item_id' => $this->product_id,
                    'warehouse_id' => $this->warehouse_id,
                    'stock' => $this->quantity
                ]);
            }

            InventoryKardex::create([
                'date_of_issue' => Carbon::now()->format('Y-m-d'),
                'item_id' => $this->product_id,
                'inventory_kardexable_id' => $inventory->id,
                'inventory_kardexable_type' => Inventory::class,
                'warehouse_id' => $this->warehouse_id,
                'quantity'=> $this->quantity
            ]);

            $icon = 'success';
            $title = Lang::get('messages.congratulations');
            $msg = 'Ingreso registrado correctamente';
        }

        if($inventory){
            $user = Auth::user();
            $activity = new Activity;
            $activity->modelOn(Inventory::class,$inventory->id);
            $activity->causedBy($user);
            $activity->routeOn(route('logistics_warehouse_inventory_movements'));
            $activity->componentOn('logistics.warehouse.movements-modal-form');
            $activity->dataOld($inventory);
            $activity->logType('movement');
            $activity->log($msg);
            $activity->save();
        }


        $this->product_id = null;
        $this->warehouse_id = null;
        $this->transaction_id = null;
        $this->quantity = 0;

        $this->dispatchBrowserEvent('response_movements_store', ['message' => $msg,'title'=> $title,'icon'=> $icon]);
    }
}
