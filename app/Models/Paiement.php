<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Paiement extends Model
{
    protected $table = 'paiements';
    protected $primaryKey = 'id_paiement';

    protected $fillable = [
      'id_paiement', '$id_mode_paiement', 'ref',
    ];

    public function creer($id_paiement, $id_mode_paiement, $ref)
    {
        try{
            $item = $this;
            $item->id_paiement = $id_paiement;
            $item->id_mode_paiement = $id_mode_paiement;
            $item->ref = $ref;
            $item->save();

        }catch(Exception $e){return $e->getMessage();}
    }


    public static function getNextID()
    {
        $lastRecord = DB::table('paiements')->orderBy('id_paiement', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_paiement + 1);
        return $result;
    }
}
