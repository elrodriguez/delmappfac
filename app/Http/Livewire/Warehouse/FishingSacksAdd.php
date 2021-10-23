<?php

namespace App\Http\Livewire\Warehouse;

use App\Models\Warehouse\DocumentFishing;
use App\Models\Warehouse\DocumentFishingDetail;
use App\Models\Warehouse\Freezer;
use App\Models\Warehouse\Sack;
use App\Models\Warehouse\SackProduced;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Block\Element\Document;
use Livewire\Component;

class FishingSacksAdd extends Component
{
    public $document_id;
    public $fish;
    public $freezers;

    public function mount($document_id){
        $this->document_id = $document_id;
        $this->listFishing();
    }
    public function render()
    {
        $this->freezers = Freezer::all();

        return view('livewire.warehouse.fishing-sacks-add');
    }
    public function newSackProduced($index){
        $this->validate([
            'fish.'.$index.'.freezer_id' => 'required',
            'fish.'.$index.'.sacks_quantity' => 'required|numeric'
        ]);
        $fish = $this->fish[$index];
        $customer = DocumentFishing::join('people','document_fishings.customer_id','people.id')
                    ->select('people.*')
                    ->where('document_fishings.id',$fish['document_fishing_id'])->first();

        $sackproduced = SackProduced::where('document_fishing_id',$fish['document_fishing_id'])->where('fishing_id',$fish['fishing_id'])->first();
        $sack = Sack::where('customer_id',$customer->id)->where('fishing_id',$fish['fishing_id'])->first();

        if($sackproduced){
            Sack::where('id',$sack->id)->decrement('stock',$sackproduced->quantity);
            SackProduced::where('id',$sackproduced->id)->update([
                'freezer_id' => $fish['freezer_id'],
                'quantity' => $fish['sacks_quantity'],
            ]);
            Sack::where('id',$sack->id)->increment('stock',$fish['sacks_quantity']);
        }else{
            if($sack){
                Sack::where('id',$sack->id)->increment('stock',$fish['sacks_quantity']);
            }else{
                $sack = Sack::create([
                    'weight' => 20,
                    'customer_id' => $customer->id,
                    'fishing_id' => $fish['fishing_id'],
                    'stock' => $fish['sacks_quantity']
                ]);
            }

            SackProduced::create([
                'document_fishing_id' => $fish['document_fishing_id'],
                'fishing_id' => $fish['fishing_id'],
                'freezer_id' => $fish['freezer_id'],
                'customer_id' => $customer->id,
                'customer' => $customer,
                'quantity' => $fish['sacks_quantity'],
                'sack_id' => $sack->id,
                'user_id' => Auth::id()
            ]);
        }
        $this->listFishing();
    }

    public function listFishing(){
        $array = DocumentFishingDetail::where('document_fishing_id',$this->document_id)
                ->select(
                    'document_fishing_id',
                    'fishing_id',
                    'item',
                    DB::raw('(SELECT freezer_id FROM sack_produceds AS t1 WHERE t1.document_fishing_id = document_fishing_details.document_fishing_id AND t1.fishing_id=document_fishing_details.fishing_id) AS freezer_id'),
                    DB::raw('(SELECT quantity FROM sack_produceds AS t1 WHERE t1.document_fishing_id = document_fishing_details.document_fishing_id AND t1.fishing_id=document_fishing_details.fishing_id) AS quantity')
                )
                ->get();
        foreach($array as $key => $row){
            $this->fish[$key] = [
                'document_fishing_id' => $row->document_fishing_id,
                'fishing_id' => $row->fishing_id,
                'fish_name' => json_decode($row->item)->description,
                'sacks_quantity' => $row->quantity,
                'freezer_id' => $row->freezer_id
            ];
        }
    }
}
