<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitMagasin extends Model
{
    use HasFactory;

    protected $table = 'PRODUIT_MAGASIN';

    public $timestamps = false;

    protected $fillable = [
        'id_magasin',
        'id_produit',
        'prix',
        'stock'
    ];

    public function magasin()
    {
        return $this->belongsTo(Magasin::class, 'id_magasin');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}