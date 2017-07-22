<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Vente extends Model
{
    protected $table = 'ventes';
    protected $primaryKey = 'id_vente';

    protected $fillable = [
        'id_vente', 'id_user', 'id_magasin',
        'id_type_transaction', 'id_paiement', 'id_remise', 'annulee',
    ];

    public static function getNextID()
    {
        $lastRecord = DB::table('ventes')->orderBy('id_vente', 'desc')->first();
        $result = ($lastRecord == null ? 1 : $lastRecord->id_vente + 1);
        return $result;
    }

    public static function createVente($id_vente, $id_mode_paiement, $ref, $id_client)
    {
        try {
            //paiement ------------------------
            $id_paiement = Paiement::getNextID();
            Paiement::creer($id_paiement, $id_mode_paiement, $ref);
            //---------------------------------
            //Vente ---------------------------
            $vente = new Vente();
            $vente->id_vente = $id_vente;
            $vente->id_magasin = Session::get('id_magasin');
            $vente->id_user = Session::get('id_user');
            $vente->id_paiement = $id_paiement;
            $vente->id_remise = null;
            $vente->id_client = $id_client;
            $vente->id_promotion = null;
            $vente->annulee = false;
            //---------------------------------
            $vente->save();

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

    public static function createVenteRemise($id_vente, $id_mode_paiement, $ref, $id_client, $taux, $raison)
    {
        try {

            //remise --------------------------
            $id_remise = Remise::getNextID();
            Remise::creer($id_remise, $taux, $raison);
            //---------------------------------
            //paiement ------------------------
            $id_paiement = Paiement::getNextID();
            Paiement::creer($id_paiement, $id_mode_paiement, $ref);
            //---------------------------------
            //Vente ---------------------------
            $vente = new Vente();
            $vente->id_vente = $id_vente;
            $vente->id_magasin = Session::get('id_magasin');
            $vente->id_user = Session::get('id_user');
            $vente->id_paiement = $id_paiement;
            $vente->id_remise = $id_remise;
            $vente->id_client = $id_client;
            $vente->id_promotion = null;
            $vente->annulee = false;
            //---------------------------------
            $vente->save();

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withAlertDanger("Erreur de creation de la transaction.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
    }

}
