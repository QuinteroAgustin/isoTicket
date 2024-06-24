<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';

    protected $table = 'F_CONTACTT';
    protected $primaryKey = 'cbMarq';
    protected $keyType = 'string';
    protected $fillable = ['CT_Num', 'CT_Nom', 'CT_Prenom', 'CT_Fonction', 'CT_Telephone', 'CT_TelPortable', 'CT_EMail', 'cbMarq'];
    public $timestamps = false;

    // Règles de validation
    public static $rules = [
        'CT_Num' => 'required|string|max:255',
        // Autres règles de validation pour les autres attributs
    ];

    public function client()
    {
        return $this->hasOne(Client::class, 'CT_Num');
    }
}
