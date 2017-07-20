<?php

namespace App\Http\Controllers;

use App\Models\Trans_article;
use App\Models\Transaction;
use App\Models\Type_transaction;
use DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function entrees()
    {
        $id_in = Type_transaction::where('libelle', 'in')->get()->first()->id_type_transaction;
        //$data = Transaction::where('id_user',Session::get('id_user'))->where('id_type_transaction',$id_in)->get();

        $id_user = Session::get('id_user');
        $data = collect(DB::select("select * from transactions where id_user=" . $id_user . " AND id_type_transaction=" . $id_in . " order by id_transaction desc"));

        /*if($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucune entree de stock");*/

        return view('Espace_Magas.liste-entrees')->withData($data);
    }

    public function entree($p_id)
    {
        $data = Trans_article::where('id_transaction', $p_id)->get();
        $transaction = Transaction::find($p_id);

        if($transaction==null)
            return redirect()->back()->withAlertWarning("L'entree de stock choisie n'existe pas.");

        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Magas.info-entree')->withData($data)->withTransaction($transaction);
    }

    public function sorties()
    {
        $id_in = Type_transaction::where('libelle', 'out')->get()->first()->id_type_transaction;
        //$data = Transaction::where('id_user',Session::get('id_user'))->where('id_type_transaction',$id_in)->get();

        $id_user = Session::get('id_user');
        $data = collect(DB::select("select * from transactions where id_user=" . $id_user . " AND id_type_transaction=" . $id_in . " order by id_transaction desc"));

        /*if($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucune entree de stock");*/

        return view('Espace_Magas.liste-entrees')->withData($data);
    }

    public function sortie($p_id)
    {
        $data = Trans_article::where('id_transaction', $p_id)->get();
        $transaction = Transaction::find($p_id);

        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Magas.info-sortie')->withData($data)->withTransaction($transaction);
    }
}
