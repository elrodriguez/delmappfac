<?php

namespace App\Http\Livewire\Academic\Administration;

use App\Models\Academic\Administration\Discount;
use App\Models\Academic\Administration\PackageItemDetail;
use App\Models\Academic\Enrollment\StudentPaymentCommitments;
use App\Models\Warehouse\Item;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class PackagesAddItemsForm extends Component
{
    public $package_id;
    public $items;
    public $discounts;
    public $item_id;
    public $discount_id;
    public $general;
    public $package_item_details = [];
    public $date_payment;
    public $to_block;

    public function mount($package_id){
        $this->package_id = $package_id;

    }
    public function render()
    {
        $this->items = Item::where('module_type','=','ACD')->get();
        $this->discounts = Discount::where('module','=','ACD')->get();
        $this->list();
        return view('livewire.academic.administration.packages-add-items-form');
    }

    public function store(){
        $this->validate([
            'item_id' => 'required'
        ]);

        $key = array_search($this->item_id, array_column($this->package_item_details, 'item_id'));
        if($key === false){

            $item_max = PackageItemDetail::where('package_id',$this->package_id)
                ->max('order_number');

            $order_number = 1;
            if($item_max){
                $order_number = $item_max+1;
            }
            if($this->date_payment){
                list($d,$m,$y) = explode('/',$this->date_payment);
                $date_payment = $y.'-'.$m.'-'.$d;
            }else{
                $date_payment = null;
            }


            PackageItemDetail::create([
                'package_id' => $this->package_id,
                'item_id' => $this->item_id,
                'discount_id' => $this->discount_id,
                'order_number' => $order_number,
                'date_payment' => $date_payment,
                'to_block' => ($this->to_block?$this->to_block:false)
            ]);
            $this->list();
            $this->date_payment = null;
        }else{
            $this->dispatchBrowserEvent('response_success_add_items', ['message' => Lang::get('messages.the_item_has_already_been_added')]);
        }
    }

    public function list(){
        //dd('ddddd');
        $package_item_details = PackageItemDetail::join('items','package_item_details.item_id','items.id')
            ->leftJoin('discounts','package_item_details.discount_id','discounts.id')
            ->select(
                'package_item_details.id',
                'items.description AS item_description',
                'items.id AS item_id',
                'items.sale_unit_price',
                'discounts.description AS discount_description',
                'discounts.percentage',
                'package_item_details.order_number',
                'package_item_details.date_payment',
                'package_item_details.to_block'
            )
            ->where('package_id',$this->package_id)
            ->orderBy('package_item_details.order_number')
            ->get();

        foreach($package_item_details as $key => $package_item_detail){
            $this->package_item_details[$key] = [
                'id' => $package_item_detail->id,
                'item_description' => $package_item_detail->item_description,
                'sale_unit_price' => $package_item_detail->sale_unit_price,
                'discount_description' => $package_item_detail->discount_description,
                'percentage' => $package_item_detail->percentage,
                'order_number' => $package_item_detail->order_number,
                'item_id' => $package_item_detail->item_id,
                'date_payment' => $package_item_detail->date_payment,
                'to_block' => $package_item_detail->to_block
            ];
        }
    }

    public function changeordernumber($direction,$id,$number,$index){
        if($direction == 1){
            $move = PackageItemDetail::where('id',$id);
            $change_array = $this->package_item_details[$index-1];
            $change = PackageItemDetail::where('id',$change_array['id']);

            $move->update([
                'order_number' => $number-1
            ]);

            $change->update([
                'order_number' => $number
            ]);
        }else if($direction == 0){
            $move = PackageItemDetail::where('id',$id);
            $change_array = $this->package_item_details[$index+1];
            $change = PackageItemDetail::where('id',$change_array['id']);

            $move->update([
                'order_number' => $number+1
            ]);

            $change->update([
                'order_number' => $number
            ]);
        }
    }

    public function deleteItem($id,$number){
        $max = PackageItemDetail::where('package_id',$this->package_id)->max('order_number');
        $exists = StudentPaymentCommitments::where('package_item_detail_id',$id)->first();

        if($exists){
            $this->dispatchBrowserEvent('response_success_delete_items', ['message' => Lang::get('messages.msg_notdelete_pid')]);
        }else{
            PackageItemDetail::where('id',$id)->delete();
            $this->package_item_details = [];
            for($c = $number;$c <=$max; $c++){
                PackageItemDetail::where('package_id',$this->package_id)
                        ->where('order_number',$c)
                        ->update([
                            'order_number' => $c - 1
                        ]);
            }
            $this->list();
        }

    }

    public function changetoblock($id,$index){
        $item = $this->package_item_details[$index];
        PackageItemDetail::where('id',$id)->update(['to_block'=>$item['to_block']]);
    }
}
