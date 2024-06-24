<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    use HasFactory;
    protected $table = 'fonctions';
    protected $primaryKey = 'id_fonction';
    protected $fillable = ['libelle', 'id_categorie', 'masquer'];
    public $timestamps = false;

    public function categorie()
    {
        return $this->hasOne(Categorie::class, 'id_categorie', 'id_categorie');
    }

    public function tickets()
    {
        return $this->belongsTo(Risque::class, 'id_risque');
    }
}
