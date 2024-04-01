<?php

namespace App\Http\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class ShopComponent extends Component
{
    use WithPagination;
    public function store($product_id,$product_name,$product_price)
    {
        Cart::add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        session()->flash('success_message','Item added in Cart');
        // return redirect()->route( 'shop.cart');
        return back(); //rediriger l'utilisateur vers la même page sur laquelle il se trouve actuellement

    }

    public function render()
    {
        $products= Product::paginate(9);
        return view('livewire.shop-component',['products'=>$products]);
    }
}
