<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commandes extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'id_client'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'commandes_produits', 'id_commande', 'id_produit')
                    ->withPivot('qte')
                    ->withTimestamps();
    }
}
