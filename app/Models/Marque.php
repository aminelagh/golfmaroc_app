<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    protected $table = 'marques';
    protected $primaryKey = 'id_marque';

    protected $fillable = [
        'id_marque', 'libelle', 'description',
        'deleted','image',
    ];

    public static function Exists($field, $value)
    {
        $data = Marque::where($field, $value)->get()->first();
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
        if($p_id==null)
            return "<i>null</i>";
        else return Marque::where('id_marque', $p_id)->get()->first()->libelle;

    }
}
