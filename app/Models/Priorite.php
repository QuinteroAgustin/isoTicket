<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priorite extends Model
{
    use HasFactory;
    protected $table = 'priorite';
    protected $primaryKey = 'id_priorite';
    protected $fillable = ['libelle', 'masquer'];
    public $timestamps = false;

    public function risque()
    {
        return $this->belongsTo(Risque::class, 'id_risque');
    }
}
