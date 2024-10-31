<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';
    protected $primaryKey = 'id_statut';
    protected $fillable = ['libelle', 'masquer', 'ordre_tri'];
    public $timestamps = false;

    public function tickets()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}
