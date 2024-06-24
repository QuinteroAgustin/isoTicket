<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forfait extends Model
{
    use HasFactory;
    protected $table = 'forfaits';
    protected $primaryKey = 'id_forfait';
    protected $fillable = ['created_at', 'valid_to', 'credit', 'id_type', 'masquer'];
    public $timestamps = false;

    public function type()
    {
        return $this->hasOne(TypeForfait::class, 'id_type', 'id_type');
    }
}
