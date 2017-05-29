<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vente extends Model
{
    protected $table = 'ventes';
    protected $primaryKey = 'id_vente';

    protected $fillable = [
      'id_vente', 'id_user','id_magasin' ,
      'id_type_transaction', 'id_paiement', 'id_remise', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('ventes')->orderBy('id_vente', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_vente + 1);
        return $result;
    }
}
