<?php

namespace App\Models;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paiments extends Model
{
    use HasFactory;
    protected $fillable = ['montant', 'Id_carte', 'id_client', 'Id_commande'];

    public function carte()
    {
        return $this->belongsTo(Cart::class, 'Id_carte');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function commande()
    {
        return $this->belongsTo(commandes::class, 'Id_commande');
    }
}
