<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_taille extends Model
{
    protected $table = 'stock_tailles';
    protected $primaryKey = 'id_stock_taille';


    protected $fillable = [
        'id_stock', 'id_stock_taille', 'id_taille_article',
        'quantite',
    ];

    public static function hasTailles($id_stock)
    {
        $x = self::where('id_stock',$id_stock)->get();
        if($x->isEmpty())
            return false;
        else return true;
    }

    public static function getTailles($id_stock)
    {
        return self::where('id_stock',$id_stock)->get();
    }
}
