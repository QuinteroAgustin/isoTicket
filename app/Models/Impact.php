<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impact extends Model
{
    use HasFactory;
    protected $table = 'impact';
    protected $primaryKey = 'id_impact';
    protected $fillable = ['libelle', 'masquer'];
    public $timestamps = false;

    public function risques()
    {
        return $this->belongsTo(Risque::class, 'id_risque');
    }
}
