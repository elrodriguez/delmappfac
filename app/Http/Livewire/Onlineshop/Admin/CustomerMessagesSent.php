<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoCustomerMessages;
use Livewire\WithPagination;
use Livewire\Component;

class CustomerMessagesSent extends Component
{
    public $search;

    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';

    public $items = [];

    public function messagesSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.onlineshop.admin.customer-messages-sent',['messages' => $this->getMessages()]);
    }

    public function getMessages(){
        return ShoCustomerMessages::where('name','like','%'.$this->search.'%')
            ->where('send',true)
            ->orderBy('created_at','DESC')
            ->paginate(50);
        
    }

    public function deleteMessage(){
        foreach($this->items AS $item){
            if($item != false){
                ShoCustomerMessages::find($item)->delete();
            }
        }
        $this->items = [];
    }


}
