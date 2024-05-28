<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cartes extends Model
{
    use HasFactory;
    
    // protected $fillable = ['numero_de_cart','cvv','solde','id_client','date_expiration'];

    protected $fillable = ['id','cvv', 'solde', 'date_expiration', 'numero_de_cart', 'id_client'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_client');
    }
}
