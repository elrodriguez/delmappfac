<?php

namespace App\Http\Livewire\Onlineshop\Admin;

use App\Models\OnlineShop\ShoItemGallery;
use Livewire\Component;

class ProductsGallery extends Component
{
    public $item_id;
    public $images;

    public function mount($item_id){
        $this->item_id = $item_id;
    }

    public function render()
    {
        $this->getImages();
        return view('livewire.onlineshop.admin.products-gallery');
    }

    public function getImages(){
        $this->images = ShoItemGallery::join('items','sho_item_galleries.item_id','items.id')
            ->select(
                'items.description',
                'sho_item_galleries.id',
                'sho_item_galleries.state',
                'sho_item_galleries.url',
                'sho_item_galleries.name',
                'sho_item_galleries.principal'
            )
            ->where('item_id',$this->item_id)
            ->get();
    }

    public function activeImage($id){
        $img = ShoItemGallery::find($id);
        if($img->state){
            $img->update(['state'=>false]);
        }else{
            $img->update(['state'=>true]);
        }
    }

    public function principalImage($id){
        $img = ShoItemGallery::find($id);
        ShoItemGallery::where('item_id',$this->item_id)->update(['principal'=>false]);
        if($img->principal){
            $img->update(['principal'=>false]);
        }else{
            $img->update(['principal'=>true]);
        }
    }

    public function destroy($id) {
        $img = ShoItemGallery::findOrFail($id);
        $image_path = public_path("storage/{$img->url}");
        if (\File::exists($image_path)) {
            \File::delete($image_path);
        }
        $img->delete();
    }
}
