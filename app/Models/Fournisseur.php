<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $table = 'fournisseurs';
    protected $primaryKey = 'id_fournisseur';

    protected $fillable = [
        'id_fournisseur', 'libelle', 'description',
        'code', 'deleted',
    ];


    public static function Exists($field, $value)
    {
        $data = Fournisseur::where($field, $value)->get()->first();
        if ($data == null) return false;
        else {
            foreach ($data as $item) {
                if ($item == $value)
                    return true;
            }
            return false;
        }
    }

    public static function getLibelle($p_id_fournisseur)
    {
        $data = Fournisseur::where('id_fournisseur', $p_id_fournisseur)->get();
        if( $data != null)
            return Fournisseur::where('id_fournisseur', $p_id_fournisseur)->get()->first()->libelle;
        else return "<i>aucun fournisseur</i>";
    }
}
