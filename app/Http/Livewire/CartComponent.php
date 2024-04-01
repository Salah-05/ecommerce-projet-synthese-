<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    public function increasequantity($rowId){
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId,$qty);
       }

       public function decreasequantity($rowId){
        $product = Cart::get($rowId);
        $qty = $product->qty - 1;
        Cart::update($rowId,$qty);
       }
       public function destroy($id)
       {
        Cart::remove($id);
        session()->flash('success_message','Item has been removed');
       }
       
    public function render()
    {
        return view('livewire.cart-component');
    }
}
