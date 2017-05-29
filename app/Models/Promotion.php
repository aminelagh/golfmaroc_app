<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class Promotion extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id_promotion';

    protected $fillable = [
        'id_promotion', 'id_article', 'id_magasin',
        'taux', 'date_debut', 'date_fin', 'active',
        'deleted',
    ];


    //fonction static permet de verifier si un promotion d un article dans un magasin est disponible
    public static function hasPromotion($p_id_article, $p_id_magasin)
    {
        //$p_id_magasin = 1;//Session::get('id_magasin');
        $promo = collect(Promotion::where('id_article', $p_id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get());
        $now = new Carbon();

        if (!$promo->isEmpty()) {
            $d = Carbon::parse($promo->first()->date_debut);
            $f = Carbon::parse($promo->first()->date_fin);
            if ($now->greaterThanOrEqualTo($d) && $now->lessThanOrEqualTo($f)) {
                return true;
            } else return false;
        } else {
            return false;
        }
    }

    public static function getTauxPromo($p_id_article, $p_id_magasin)
    {
        return $promo = collect(Promotion::where('id_article', $p_id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get())->first()->taux;
        if (Promotion::hasPromotion($p_id_article, $p_id_magasin)) {
            return $promo = collect(Promotion::where('id_article', $p_id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get())->first()->taux;
        } else return 0;

    }


}
