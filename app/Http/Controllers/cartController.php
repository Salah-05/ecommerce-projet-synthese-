<?php

namespace App\Http\Controllers;

use App\Models\cartes;
use App\Models\commandes;
use App\Models\Coupon;
use App\Models\paiments;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;

class cartController extends Controller
{
    public function ajouterCart(Request $request)
    {
        $request->validate([
            'CVV' => 'required|digits_between:3,4',
            'numero_de_cart' => 'required|digits_between:13,19',
        ]);

        $date_expiration = Carbon::now()->addYear()->format('Y-m-d H:i:s');
        $randomNumber = '4000';

        cartes::create([
            'numero_de_cart' => $request->numero_de_cart,
            'cvv' => $request->CVV,
            'solde' => $randomNumber,
            'id_client' => auth()->user()->id,
            'date_expiration' => $date_expiration,
        ]);
        
        return redirect()->back()->with('success', 'Carte ajoutée avec succès');
    }

    public function modifiercart(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required|integer|exists:cartes,id', 
            'CVV' => 'required|digits_between:3,4',
            'numero_de_cart' => 'required|digits_between:13,19',
        ]);
    
        $id = $request->input('id');
    
        try {
            // Find the cart item by ID
            $cart = cartes::findOrFail($id);
    
            // Calculate the expiration date
            $date_expiration = Carbon::now()->addYear()->format('Y-m-d H:i:s');
    
            // Random number assignment (you can change this logic as needed)
            $randomNumber = '4000';
    
            // Update the cart with new data
            $cart->update([
                'numero_de_cart' => $request->input('numero_de_cart'),
                'cvv' => $request->input('CVV'),
                'solde' => $randomNumber,
                'id_client' => auth()->user()->id,
                'date_expiration' => $date_expiration,
            ]);
    
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Carte mise à jour avec succès');
        } catch (\Exception $e) {
            // Handle the exception and provide feedback
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour de la carte');
        }
    }
    
    
    public function addCommande(Request $request)
    {
        $coupon = $request->coupon;
        $coupon_fd = 0;
    
        if ($coupon) {
            $coupon_fd = Coupon::where("coupon", $coupon)->pluck('prix')->first();
            if (is_null($coupon_fd)) {
                $coupon_fd = 0;
            }
        }
    
        // Validate and decode the JSON content
        $content = json_decode($request->input('content'), true);
    
        if (!$content) {
            return redirect()->back()->withErrors('Le contenu du panier est invalide.');
        }
    
        if ($coupon_fd != 0) {
            return redirect()->back()->withErrors('Coupon invalide.');
        }
    
        $code = Str::random(5);
        $expiryDate = Carbon::now()->addYear();
    
        $solde = cartes::where('id_client', auth()->user()->id)->pluck('solde')->first(); // Added first() to get the actual value
        $total = $request->input('total');
    
        // Corrected the logic
        if ($solde < $total) {
            return redirect()->back()->withErrors('Solde insuffisant');
        }
    
        if ($total <= $solde) {
            $discountPercentage = 3;
            $prix = (int)$total * ((int)$discountPercentage / 100);
            $client = cartes::where('id_client', auth()->user()->id)->value('id');
    
            // Create the coupon
            $coupon = Coupon::create([
                'code' => $code,
                'discount_percentage' => $discountPercentage,
                'expiry_date' => $expiryDate,
                'prix' => $prix,
                'id_client' => auth()->user()->id,
            ]);
    
            cartes::where('id_client', auth()->user()->id)->update([
                'solde' => $solde - $total,
            ]);
    
            // Create the order
            $commande = Commandes::create([
                'status' => 'pending',
                'montant' => $total,
                'id_client' => auth()->user()->id,
                'coupon_code' => $code,
            ]);
    
            // Attach products to the order
            foreach ($content as $item) {
                $commande->products()->attach($item['id'], ['qte' => $item['qty']]);
            }
    
            // Create payment record
            Paiments::create([
                'montant' => (int)$total - (int)($coupon_fd ?? 0), // Fixed type casting
                'Id_carte' => $client,
                'id_client' => auth()->user()->id,
                'Id_commande' => $commande->id,
            ]);
    
            // Clear the cart (if needed)
            Cart::destroy();
    
            // Return a success response
            return redirect()->back()->with('success', 'La commande a été ajoutée avec succès');
        } else {
            return redirect()->back()->withErrors('Solde insuffisant');
        }
    }
    
}    
