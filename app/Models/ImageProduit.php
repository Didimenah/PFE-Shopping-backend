<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduit extends Model
{
    use HasFactory;

    protected $table = 'IMAGE_PRODUIT';

    protected $primaryKey = 'id_image';

    public $timestamps = false;

    protected $fillable = [
        'url_image',
        'id_produit'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}