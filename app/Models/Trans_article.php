<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trans_article extends Model
{
    protected $table = 'trans_articles';
    protected $primaryKey = 'id_tras_article';

    protected $fillable = [
      'id_tras_article', 'id_transaction','id_article' ,
      'quantite', 'prix'
    ];
}
