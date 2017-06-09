<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock_taille extends Model
{
    protected $table = 'stock_tailles';
    protected $primaryKey = 'id_stock_taille';



    protected $fillable = [
      'id_stock', 'id_stock_taille','id_taille_article' ,
      'quantite',
    ];
}
