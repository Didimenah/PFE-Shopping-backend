<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'CATEGORIE';

    protected $primaryKey = 'id_categorie';

    public $timestamps = false;

    protected $fillable = [
        'nom_categorie',
        'description'
    ];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_categorie');
    }
}