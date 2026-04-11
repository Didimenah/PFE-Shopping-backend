<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'UTILISATEUR';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'mot_de_passe',
        'role',
        'date_creation',
        'matricule_vehicule'
    ];

    protected $hidden = [
        'mot_de_passe'
    ];

    /*
    |-----------------------------------
    | Relations
    |-----------------------------------
    */

    public function magasins()
    {
        return $this->hasMany(Magasin::class, 'id_user');
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_user');
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class, 'id_user');
    }
}