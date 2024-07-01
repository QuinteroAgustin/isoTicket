<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';

    protected $table = 'F_COMPTET';
    protected $primaryKey = 'CT_Num';
    protected $keyType = 'string';
    protected $fillable = ['CT_Intitule', 'CT_Contact', 'CT_Adresse', 'CT_CodePostal', 'CT_Ville', 'CT_Siret', 'CT_Telephone'];
    public $timestamps = false;

    // Règles de validation
    public static $rules = [
        'CT_Num' => 'required|string|max:255',
        // Autres règles de validation pour les autres attributs
    ];

    public function contact()
    {
        return $this->hasMany(Contact::class, 'CT_Num');
    }

    public function collaborateur()
    {
        return $this->hasOne(Collaborateur::class, 'CO_No', 'CO_No');
    }
}
