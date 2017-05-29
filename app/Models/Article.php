<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id_article';

    protected $fillable = [
        'id_article', 'id_fournisseur', 'id_categorie','id_marque',
        'designation_c', 'designation_l',
        'code_barre', 'num_article',
        'couleur', 'taille', 'sexe', 'prix_achat', 'prix_vente',
        'deleted', 'image','valide'
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

    static function Exists($field, $value)
    {
        $data = Article::where($field, $value)->get()->first();
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
