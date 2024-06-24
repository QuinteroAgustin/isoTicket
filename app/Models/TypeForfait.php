<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeForfait extends Model
{
    use HasFactory;
    protected $table = 'type_forfait';
    protected $primaryKey = 'id_type';
    protected $fillable = ['libelle'];
    public $timestamps = false;

    public function forfaits()
    {
        return $this->belongsTo(Forfait::class, 'id_forfaits');
    }
}
