<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'PRODUIT';

    protected $primaryKey = 'id_produit';

    public $timestamps = false;

    protected $fillable = [
        'nom_produit',
        'description',
        'id_categorie'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function images()
    {
        return $this->hasMany(ImageProduit::class, 'id_produit');
    }

    public function magasins()
    {
        return $this->hasMany(ProduitMagasin::class, 'id_produit');
    }
}