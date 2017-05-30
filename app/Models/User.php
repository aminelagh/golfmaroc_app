<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_magasin', 'telephone', 'description',
        'nom', 'prenom', 'ville', 'email', 'password',
        'deleted', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function EmailExist($email)
    {
        $x = User::where('email', $email)->first();
        if ($x != null)
            return true;
        else return false;
    }

    public static function EmailExistForUpdate($email)
    {
        $x = User::where('email', $email)->first();
        if ($x == null || $x->id == Session::get('id_user'))
            return false;
        else
            return true;
    }

    public static function updateSession($p_id)
    {
        $user = User::where('id', $p_id)->first();
        Session::put('nom', $user->nom);
        Session::put('prenom', $user->prenom);
        Session::put('email', $user->email);
        Session::put('id_magasin', $user->id_magasin);
    }

    public static function getRole($p_id)
    {
        $role_user = User::where('id', $p_id)->first();
    }
}
