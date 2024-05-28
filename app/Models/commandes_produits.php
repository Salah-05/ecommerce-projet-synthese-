<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class commandes_produits extends Pivot
{
    use HasFactory;
    protected $table = 'commandes_produits';

    public function product()
    {
        return $this->belongsTo(Product::class, 'Id_produit');
    }

    public function commande()
    {
        return $this->belongsTo(commandes::class, 'Id_commande');
    }
}
