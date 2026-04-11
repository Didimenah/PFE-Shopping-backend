<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    use HasFactory;

    protected $table = 'MAGASIN';

    protected $primaryKey = 'id_magasin';

    public $timestamps = false;

    protected $fillable = [
        'nom_magasin',
        'adresse',
        'telephone',
        'latitude',
        'longitude',
        'description',
        'heure_ouverture',
        'heure_fermeture',
        'id_user'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_user');
    }

    public function produits()
    {
        return $this->hasMany(ProduitMagasin::class, 'id_magasin');
    }
}