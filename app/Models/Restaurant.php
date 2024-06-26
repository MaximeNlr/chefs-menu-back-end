<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongTo (User::class, 'user_id');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function table()
    {
        return $this->hasMany(Table::class);
    }
}
 
