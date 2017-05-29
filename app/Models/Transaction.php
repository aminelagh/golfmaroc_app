<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
      'id_transaction', 'id_user','id_magasin' ,
      'id_type_transaction', 'id_paiement', 'id_remise', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('transactions')->orderBy('id_transaction', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_transaction + 1);
        return $result;
    }
}
