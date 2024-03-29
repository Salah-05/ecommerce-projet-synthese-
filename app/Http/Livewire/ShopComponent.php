<?php

namespace App\Http\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    public function render()
    {
        $products= Product::paginate(9);
        return view('livewire.shop-component',['products'=>$products]);
    }
}
