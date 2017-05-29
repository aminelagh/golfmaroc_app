<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vente_article extends Model
{
    protected $table = 'vente_articles';
    protected $primaryKey = 'id_vente_article';

    protected $fillable = [
      'id_vente_article', 'id_vente','id_article' ,
      'id_taille_article', 'quantite', 'prix', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('vente_articles')->orderBy('id_vente_article', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_vente_article + 1);
        return $result;
    }
}
