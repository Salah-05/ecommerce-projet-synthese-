<?php

namespace App\Http\Livewire;

use App\Models\Coupon;
use Livewire\Component;

class Coupons extends Component
{
    public function render()
    {
        $coupons = Coupon::where('id_client',auth()->user()->id)->paginate(6);
        return view('livewire.coupons',['coupons' => $coupons]);
    }
}
