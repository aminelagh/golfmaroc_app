<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_categorie';

    protected $fillable = ['libelle', 'description', 'deleted',];

    public static function Exists($field, $value)
    {
        $data = Categorie::where($field, $value)->get()->first();
        if ($data == null) return false;
        else {
            foreach ($data as $item) {
                if ($item == $value)
                    return true;
            }
            return false;
        }
    }

    public static function getLibelle($p_id)
    {
        //return Categorie::where('id_categorie', $p_id)->get()->first()->libelle;

        $data = Categorie::where('id_categorie', $p_id)->get();
        if( $data != null)
            return Categorie::where('id_categorie', $p_id)->get()->first()->libelle;
        else return "<i>aucune categorie</i>";
    }

}
