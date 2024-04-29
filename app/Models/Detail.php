<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = ['produit_id', 'quantite'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
