<?php

namespace App\Http\Livewire\Logistics\Warehouse;

use Livewire\Component;
use App\Models\Logistics\Production\Project;
use App\Models\Logistics\Production\ProjectMaterial;
use App\Models\Logistics\Production\Stage;
use App\Models\Warehouse\Inventory;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\ItemBrand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use App\Models\Warehouse\InventoryTransaction;

class ProjectOrderMaterialsForm extends Component
{
    public $description;
    public $materials = [];
    public $project_id;
    public $project_description;
    public $stages = [];
    public $stage_id;
    public $item_id;
    public $project;
    public $warehouse_id = 1;

    public function mount($project_id){
        $this->project_id = $project_id;
        $this->project = Project::find($project_id);
        $this->project_description = $this->project->description;
    }

    public function render()
    {
        $this->materialsList();
        $this->stages = Stage::where('project_id',$this->project_id)->get();
        return view('livewire.logistics.warehouse.project-order-materials-form');
    }

    public function store(){

        $this->validate([
            'stage_id' => 'required',
            'item_id' => 'required',
        ]);
        $item = ItemBrand::join('items','item_brands.id_item','items.id')
                ->where('item_brands.id',$this->item_id)
                ->select(
                    'item_brands.id_item',
                    'items.purchase_unit_price',
                    'item_brands.id_brand'
                )
                ->first();
        ProjectMaterial::create([
            'item_id' => $item->id_item,
            'project_id' => $this->project_id,
            'stage_id' => $this->stage_id,
            'quantity' => 1,
            'unit_price' => $item->purchase_unit_price,
            'expenses' => ($item->purchase_unit_price*1),
            'brand_id' => $item->id_brand
        ]);

        $this->item_id = null;
        $this->stage_id = null;
        $this->dispatchBrowserEvent('response_projects_materials', ['message' => Lang::get('messages.successfully_registered')]);
    }

    public function materialsList(){
        $materials = ProjectMaterial::join('items','project_materials.item_id','items.id')
                ->join('unit_types','items.unit_type_id','unit_types.id')
                ->where('project_id',$this->project_id)
                ->select(
                    'project_materials.id',
                    'project_materials.quantity',
                    'project_materials.unit_price',
                    'project_materials.expenses',
                    'items.description',
                    'items.id AS item_id',
                    'items.module_type',
                    'project_materials.state',
                    'unit_types.description AS measure',
                    DB::raw("(SELECT name FROM brands WHERE brands.id=project_materials.brand_id) as name")
                )->get();
        foreach($materials as $key => $material){
            $this->materials[$key] = [
                'id' => $material->id,
                'quantity' => $material->quantity,
                'unit_price' => $material->unit_price,
                'expenses' => $material->expenses,
                'description' => $material->description,
                'item_id' => $material->item_id,
                'module_type' => $material->module_type,
                'state' => $material['state'],
                'measure' => $material->measure,
                'name' => $material->name,
                'image_url' => asset('storage/items/'.$material->item_id.'.jpg')
            ];
        }
    }

    public function change_state_rejected($id){
        ProjectMaterial::where('id',$id)->update([
            'state' => 4
        ]);
    }
    public function change_state_accepted(){
        $inventory_transaction_tool = InventoryTransaction::where('id','30')->first();
        $inventory_transaction_material = InventoryTransaction::where('id','10')->first();

        foreach($this->materials as $item){
            if($item['state'] == 1){
                ProjectMaterial::where('id',$item['id'])->update([
                    'state' => 2
                ]);
                if($item['module_type'] == 'GOO'){
                    $inventory = Inventory::create([
                        'description' => $inventory_transaction_tool->description,
                        'item_id' => $item['item_id'],
                        'quantity' => $item['quantity'],
                        'warehouse_id' => $this->warehouse_id,
                        'inventory_transaction_id' => $inventory_transaction_tool->id
                    ]);
                    InventoryKardex::create([
                        'date_of_issue' => Carbon::now()->format('Y-m-d'),
                        'item_id' => $item['item_id'],
                        'inventory_kardexable_id' => $inventory->id,
                        'inventory_kardexable_type' => Inventory::class,
                        'warehouse_id' => $this->warehouse_id,
                        'quantity'=> (-$item['quantity'])
                    ]);
                }else{
                    $inventory = Inventory::create([
                        'description' => $inventory_transaction_material->description,
                        'item_id' => $item['item_id'],
                        'quantity' => $item['quantity'],
                        'warehouse_id' => $this->warehouse_id,
                        'inventory_transaction_id' => $inventory_transaction_material->id
                    ]);
                    InventoryKardex::create([
                        'date_of_issue' => Carbon::now()->format('Y-m-d'),
                        'item_id' => $item['item_id'],
                        'inventory_kardexable_id' => $inventory->id,
                        'inventory_kardexable_type' => Inventory::class,
                        'warehouse_id' => $this->warehouse_id,
                        'quantity'=> (-$item['quantity'])
                    ]);
                }
            }
        }
    }
}
