<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;

    protected $table = 'LIGNE_COMMANDE';

    public $timestamps = false;

    protected $fillable = [
        'id_produit',
        'id_commande',
        'quantite',
        'prix_unitaire'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}