<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id_article';

    protected $fillable = [
        'id_article', 'id_fournisseur', 'id_categorie', 'id_marque',
        'designation',
        'code', 'ref', 'alias',
        'couleur', 'sexe', 'prix_a', 'prix_v',
        'deleted', 'image', 'valide'
    ];

    public static function getPrixPromo($p_id_article, $p_id_magasin)
    {
        $prixHT = Article::where('id_article', $p_id_article)->first()->prix_vente;
        $prixTTC = $prixHT * 1.2;

        if (Promotion::hasPromotion($p_id_article, $p_id_magasin)) {
            $taux = Promotion::getTauxPromo($p_id_article, $p_id_magasin);
            $prix = $prixTTC * (1 - $taux / 100);
            return $prix;
        } else {
            return $prixTTC;
        }
    }

    public static function getPrix_TTC($prix_HT)
    {
        return number_format(($prix_HT * 1.2), 2);
    }

    static function getNextID()
    {
        $lastRecord = DB::table('articles')->orderBy('id_article', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_article + 1);
        return $result;
    }

    public static function CodeExists($code)
    {
        $data = self::where('code', $code)->get()->first();
        if ($data == null)
            return false;
        else return true;
    }

    public static function hasNonValideArticles()
    {
        $data = self::where('valide',false)->where('deleted',false)->get();
        if($data->isEmpty() )
            return false;
        else return true;
    }

    public static function nombreNonValideArticles()
    {
        $data = self::where('valide',false)->where('deleted',false)->get();
        return count($data);

    }

    public static function CodeExistForUpdate($p_id, $code)
    {
        $x = self::where('code', $code)->where('id_article', '!=', $p_id)->first();
        if ($x == null)
            return false;
        else
            return true;
    }

}
