<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbonnementLigne extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';

    protected $table = 'F_ABOLIGNE';
    protected $primaryKey = 'AB_No';
    protected $keyType = 'string';
    protected $fillable = ['AR_Ref', 'AL_Design'];
    public $timestamps = false;
}
