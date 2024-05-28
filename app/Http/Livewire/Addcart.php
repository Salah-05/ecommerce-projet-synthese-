<?php
namespace App\Http\Livewire;

use App\Models\cartes;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Addcart extends Component
{
    public function render()
    {
        // Fetch the card details for the authenticated user
        $card = cartes::where('id_client', Auth::id())->first();

        return view('livewire.addcart', [
            'cvv' => $card->cvv ?? null,
            'numero_du_cart' => $card->numero_de_cart ?? null,
            'id_cart' => $card->Id_carte ?? null

        ]);
    }
    
}

