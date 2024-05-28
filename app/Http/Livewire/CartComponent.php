<?php

namespace App\Http\Livewire;

use App\Models\cartes;
use App\Models\Coupon;
use Livewire\Component;
use Cart;
use Gloudemans\Shoppingcart\Cart as ShoppingcartCart;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    public $couponCode;
    public function increasequantity($rowId){
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId,$qty);
        $this->emitTo('cart-icon-component','refreshComponent');
       }

       public function decreasequantity($rowId){
        $product = Cart::get($rowId);
        $qty = $product->qty - 1;
        Cart::update($rowId,$qty);
        $this->emitTo('cart-icon-component','refreshComponent');
       }

       public function destroy($id)
       {
        Cart::remove($id);
        $this->emitTo('cart-icon-component','refreshComponent');
        session()->flash('success_message','Item has been removed');
       
       }
       
       public function clearAll(){
        Cart::destroy();
        $this->emitTo('cart-icon-component','refreshComponent');
       }
       
    public function render()
    {
        $card = cartes::where('id_client', Auth::id())->first();
        $mode = 'none';
        $modeinfo = 'text';
        $modeblock = 'block';
        if($card){
            $mode = 'block';
            $modeinfo = 'password';
            $modeblock = 'none';
        };
        return view('livewire.cart-component',[
            'cvv' => $card->cvv ?? null,
            'id' => $card->id ?? null,
            'numero_du_cart' => $card->numero_de_cart ?? null,
            'id_cart' => $card->Id_carte ?? null,
            'mode' => $mode,
            'modeinfo' => $modeinfo,
            'modeblock'=> $modeblock
        ]);
    }
    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->couponCode)->first();
    
        if ($coupon && is_numeric($coupon->prix)) {
            $discount = (float) $coupon->prix;
            $content = Cart::content();
    

            foreach ($content as $item) {
                $newPrice = max(0, $item->price - $discount / $item->qty);
                Cart::update($item->rowId, ['price' => $newPrice]);
            }
    
            $this->emit('couponApplied');
            session()->flash('success_message', 'Coupon applied successfully!');
            Coupon::destroy($coupon->id);
        } else {
            $this->addError('couponCode', 'Invalid coupon code!');
        }
    }
    
    
    
    
    

}
