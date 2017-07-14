<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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
    public static function hasPromotion($p_id_article)
    {
        $p_id_magasin = Session::get('id_magasin');
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

    public static function getTauxPromo($p_id_article)
    {
        $p_id_magasin = Session::get('id_magasin');
        //return $promo = collect(Promotion::where('id_article', $p_id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get())->first()->taux;
        if (Promotion::hasPromotion($p_id_article)) {
            return $promo = collect(Promotion::where('id_article', $p_id_article)->where('id_magasin', $p_id_magasin)->where('active', true)->get())->first()->taux;
        } else return 0;

    }

    public static function Exists($id_magasin, $id_article)
    {
        $data = Promotion::where('id_article', $id_article)->where('id_magasin', $id_magasin)->where('active', true)->where('deleted', false)->get();
        if ($data->isEmpty())
            return false;
        else return true;
    }

    public static function getPromotion($id_magasin, $id_article)
    {
        $data = Promotion::where('id_article', $id_article)->where('id_magasin', $id_magasin)->get();
        if ($data->isEmpty())
            return null;
        else return $data->first();
    }

    public static function isDate($value)
    {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


}
