<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    protected $table = 'password_resets';
    protected $primaryKey = 'id_reset';
    public $timestamps = false; // Si tu n'utilises pas les timestamps Laravel

    protected $fillable = [
        'email',
        'token',
        'created_at',
        'used',
    ];
}
