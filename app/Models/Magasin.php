<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magasin extends Model
{
    protected $table = 'magasins';
    protected $primaryKey = 'id_magasin';

    protected $fillable = [
        'id_magasin', 'libelle',
        'ville', 'agent', 'telephone',
        'email', 'adresse',
        'deleted',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('magasins')->orderBy('id_magasin', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_magasin + 1);
        return $result;
    }

    public static function getLibelle($id_magasin)
    {
        return Magasin::where('id_magasin', $id_magasin)->first()->libelle;
    }


    public static function Exists($field, $value)
    {
        $data = Magasin::where($field, $value)->get()->first();
        if ($data == null) return false;
        else {
            foreach ($data as $item) {
                if ($item == $value)
                    return true;
            }
            return false;
        }
    }
}
