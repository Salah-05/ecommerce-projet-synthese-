<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\commandes;
use Illuminate\Http\Client\Request;

class CheckoutComponent extends Component
{
    public function render()
    {
        $id = auth()->user()->id;
        
        $commandes = commandes::with('products')->where('id_client',$id)->paginate(2);
        return view('livewire.checkout-component',['commandes'=>$commandes]);
    }
    public function cancel(Request $request)
    {
        $id = $request->input('id');
        $commande = commandes::findOrFail($id);
        $commande->destroy($id);
        return redirect()->back()->with('message','Commande annulée avec succès.');
    }
}
