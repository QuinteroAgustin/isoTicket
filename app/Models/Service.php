<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $primaryKey = 'id_service';
    protected $fillable = ['libelle', 'masquer'];
    public $timestamps = false;

    public function techniciens()
    {
        return $this->belongsTo(Technicien::class, 'id_technicien');
    }

    public function categories()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }
}
