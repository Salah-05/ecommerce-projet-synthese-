<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'regular_price', 'sale_price', 'SKU', 'stock_status', 'featured', 'quantity', 'image', 'images', 'category_id'
    ];

    public function commandes()
    {
        return $this->belongsToMany(commandes::class, 'commandes_produits', 'Id_produit', 'Id_commande')
                    ->withPivot('qte')
                    ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(reviews::class);
    }
    
}
