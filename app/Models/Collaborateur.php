<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborateur extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';

    protected $table = 'F_COLLABORATEUR';
    protected $primaryKey = 'CO_No';
    protected $keyType = 'string';
    protected $fillable = ['CO_No', 'CO_Nom', 'CO_Prenom', 'CO_Fonction'];
    public $timestamps = false;

    public function client()
    {
        return $this->hasOne(Contact::class, 'CO_No', 'CO_No');
    }
}
