<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $table = 'fournisseurs';
    protected $primaryKey = 'id_fournisseur';

    protected $fillable = [
        'id_fournisseur', 'libelle',
        'code', 'deleted',
    ];


    public static function CodeExists($value)
    {
        $data = Fournisseur::where('code', $value)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function LibelleExists($value)
    {
        $data = Fournisseur::where('libelle', $value)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function getLibelle($p_id)
    {
        $data = Fournisseur::where('id_fournisseur', $p_id)->get()->first();
        if ($data != null)
            return $data->libelle;
        else return null;
    }

    public static function LibelleExistForUpdate($p_id, $libelle)
    {
        $x = Fournisseur::where('libelle', $libelle)->where('id_fournisseur', '!=', $p_id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }

    public static function CodeExistForUpdate($p_id, $code)
    {
        $x = Fournisseur::where('code', $code)->where('id_fournisseur', '!=', $p_id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }
}
