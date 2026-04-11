<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;

    protected $table = 'LIVRAISON';

    protected $primaryKey = 'id_livraison';

    public $timestamps = false;

    protected $fillable = [
        'date_livraison',
        'statut_livraison',
        'latitude_livreur',
        'longitude_livreur',
        'commission_livreur',
        'id_user'
    ];

    public function livreur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_user');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_livraison');
    }
}