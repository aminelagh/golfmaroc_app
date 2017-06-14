<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $primaryKey = 'id_stock';


    protected $fillable = [
        'id_stock', 'id_article', 'id_magasin',
        'quantite_min', 'quantite_max',
    ];


    //Creer le stock d un magasin
    public static function addStock(Request $request)
    {
        //dump($request->get('id_article'));

        $id_magasin = request()->get('id_magasin');

        //array des element du formulaire
        $id_article = $request->get('id_article');
        $designation = $request->get('designation');//request()->get('designation');
        $quantite_min = $request->get('quantite_min');//request()->get('quantite_min');
        $quantite_max = $request->get('quantite_max');//request()->get('quantite_max');

        $error1 = "";
        $hasError1 = false;
        $error2 = "";
        $hasError2 = false;
        $nbre_articles = 0;

        for ($i = 1; $i <= count($id_article); $i++) {
            //verifier si l utilisateur n a pas saisi les quantites min ou Max
            if ($quantite_min[$i] == null || $quantite_max[$i] == null) continue;

            if ($quantite_min[$i] >= $quantite_max[$i]) {
                $hasError1 = true;
                $error1 = $error1 . "<li>Quantite min > Quantite max pour l'article numero $i: <b>" . $designation[$i] . "</b>";
            }

            if ($quantite_min[$i] <= $quantite_max[$i]) {
                $item = new Stock;
                $item->id_magasin = $id_magasin;
                $item->id_article = $id_article[$i];
                $item->quantite_min = $quantite_min[$i];
                $item->quantite_max = $quantite_max[$i];

                try {
                    $item->save();
                    $nbre_articles++;
                } catch (\Exception $e) {
                    $error2 = $error2 . "<li>Erreur d'ajout de l'article: <b>" . $designation[$i] . "</b> <br>Message d'erreur: " . $e->getMessage() . ". ";
                    $hasError2 = true;
                }
            }
        }


        if ($hasError1)
            redirect()->back()->withInput()->withAlertWarning($error1)->withalignWarning("right")->withTimerWarning(5000);
        if ($hasError2)
            redirect()->back()->withInput()->withAlertDanger($error2)->withalignDanger("left")->withTimerDanger(0);
        if ($hasError1 || $hasError2)
            return redirect()->back()->withInput();
        else {
            if ($nbre_articles == 1)
                return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' article.');
            else
                return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' articles.');
        }
    }

    //Stock IN d un magasin
    public static function addStockIN(Request $request)
    {

        $id_magasin = request()->get('id_magasin');
        $id_stocks = request()->get('id_stock');
        $quantiteINs = request()->get('quantiteIN');
        $id_taille_artiles = request()->get('id_taille_article');
        //$quantite = request()->get('quantite');

        $id_stransaction = Transaction::getNextID();


        $transaction = new Transaction();
        $transaction->id_stransaction = $id_stransaction;
        $transaction->id_magasin = $id_magasin;
        $transaction->id_type_transaction = Type_transaction::where('libelle', "in")->get()->first()->id_type_transaction;
        $transaction->annulee = false;


        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteINs[$id_stock])) {

                $stock = Stock::find($id_stock);
                echo "Stock: " . $stock->id_stock . "<br> article: " . Article::getDesignation($stock->id_article) . " | quantite_min: " . $stock->quantite_min . "| quantite_max: " . $stock->quantite_max . " <br> ";

                $i = 1;
                foreach ($quantiteINs[$id_stock] as $quantite) {
                    if ($quantite == null || $quantite == 0) //continue;
                        echo "Skip: ";
                    else
                        echo "handling... ";
                    echo " ( " . $quantite . " - " . Taille_article::getTaille($id_taille_artiles[$id_stock][$i]) . " ) , ";
                    $i++;
                }
            }
            echo "<hr>";
        }
    }
}
