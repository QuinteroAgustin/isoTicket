<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technicien extends Model
{
    use HasFactory;
    protected $table = 'techniciens';
    protected $primaryKey = 'id_technicien';
    protected $fillable = ['nom', 'prenom', 'email', 'password', 'created_at', 'id_role', 'id_service', 'masquer'];
    public $timestamps = false;

    public function service()
    {
        return $this->hasOne(Service::class, 'id_service', 'id_service');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id_role', 'id_role');
    }

    /**
     * Attempt to log in the user.
     *
     * @param  string  $email
     * @param  string  $password
     * @return bool
     */
    public static function login($email, $password)
    {
        $technicien = static::where('email', $email)->first();
        //dd($technicien);
        if ($technicien && Hash::check($password, $technicien->password)) {
            session()->put('id_technicien', $technicien->id_technicien);
            session()->put('technicien', $technicien);
            return true;
        }

        return false;
    }

    /**
     * Log out the currently authenticated user.
     *
     * @return void
     */
    public static function logout()
    {
        session()->forget('id_technicien');
    }
    /**
     * Get the current authenticated user ID.
     *
     * @return mixed
     */
    public static function getTechId()
    {
        return session('id_technicien');
    }

    /**
     * Check if the user is authenticated.
     *
     * @return bool
     */
    public static function isAuthenticated()
    {
        return session()->has('id_technicien');
    }


}
