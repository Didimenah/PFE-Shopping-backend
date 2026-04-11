<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = 'COMMANDE';

    protected $primaryKey = 'id_commande';

    public $timestamps = false;

    protected $fillable = [
        'date_commande',
        'statut',
        'total',
        'adresse_livraison',
        'telephone_livraison',
        'id_livraison',
        'id_user'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_user');
    }

    public function livraison()
    {
        return $this->belongsTo(Livraison::class, 'id_livraison');
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class, 'id_commande');
    }
}