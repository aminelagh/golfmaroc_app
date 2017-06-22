<?php

namespace App\Http\Controllers;

use App\Models\Trans_article;
use App\Models\Transaction;
use App\Models\Type_transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function entrees()
    {
        $id_in = Type_transaction::where('libelle','in')->get()->first()->id_type_transaction;
        $data = Transaction::where('id_user',Session::get('id_user'))->where('id_type_transaction',$id_in)->get();

        /*if($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucune entree de stock");*/

        return view('Espace_Magas.liste-entrees')->withData($data);
    }

    public function entree($p_id)
    {
        $data = Trans_article::where('id_transaction',$p_id)->get();
        $transaction = Transaction::find($p_id);

        if($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Aucun article");

        return view('Espace_Magas.info-entree')->withData($data)->withTransaction($transaction);
    }
}
