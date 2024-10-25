<?php

namespace App\Models;

use App\Models\AbonnementLigne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abonnement extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';

    protected $table = 'F_ABONNEMENT';
    protected $primaryKey = 'AB_No';
    protected $keyType = 'string';
    protected $fillable = ['CT_Num', 'AB_Intitule', 'AB_Contrat', 'AB_Debut', 'AB_Fin', 'AB_FinAbo', 'N_de_Srie', 'H_INFO', 'H_SAGE', 'H_PILOTAGE', 'F_DEMIJOUR', 'Niveau_Service'];
    public $timestamps = false;

    public function lignes()
    {
        return $this->hasMany(AbonnementLigne::class, 'AB_No', 'AB_No');
    }
}
