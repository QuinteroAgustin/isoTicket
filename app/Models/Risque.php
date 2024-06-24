<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risque extends Model
{
    use HasFactory;
    protected $table = 'risque';
    protected $primaryKey = 'id_risque';
    protected $fillable = ['libelle', 'icon', 'fond', 'id_impact', 'id_priorite'];
    public $timestamps = false;

    public function priorite()
    {
        return $this->hasOne(Priorite::class, 'id_priorite', 'id_priorite');
    }

    public function impact()
    {
        return $this->hasOne(Impact::class, 'id_impact', 'id_impact');
    }
}
