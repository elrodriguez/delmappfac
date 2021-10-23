<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoCustomerMessages;
use Livewire\WithPagination;
use Livewire\Component;

class CustomerMessagesTrash extends Component
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
        return view('livewire.onlineshop.admin.customer-messages-trash',['messages' => $this->getMessages()]);
    }
    public function getMessages(){
        return ShoCustomerMessages::where('name','like','%'.$this->search.'%')
            ->onlyTrashed()
            ->orderBy('created_at','DESC')
            ->paginate(50);
        
    }

    public function deleteMessage(){
        foreach($this->items AS $item){
            if($item != false){
                ShoCustomerMessages::where('id',$item)->forceDelete();
            }
        }
        $this->items = [];
    }

    public function restoreMessage(){
        foreach($this->items AS $item){
            if($item != false){
                ShoCustomerMessages::withTrashed()
                    ->where('id', $item)
                    ->restore();;
            }
        }
        $this->items = [];
    }

}
