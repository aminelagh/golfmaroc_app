<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Transaction;
use App\Models\Type_transaction;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use App\Models\Trans_article;
use App\Models\Paiement;
use App\Models\Mode_paiement;
use \Exception;

class StockController extends Controller
{

    /*****************************************************************************
     * Lister Stocks
     *****************************************************************************/
    public function listerStocks($p_id_magasin)
    {
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->with('alert_warning', 'Le stock de ce magasin est vide.');
        else
            return view('Espace_Magas.liste-stocks')->with('data', $data);
    }

    /*****************************************************************************
     * Afficher le fomulaire d'ajout pour le stock
     *****************************************************************************/
    public function addStock($p_id_magasin)
    {
        $magasin = Magasin::where('id_magasin', $p_id_magasin)->first();        //$articles = Article::all();

        //Procédure stockee dans la db: permet de retourner la liste des articles qui ne figurent pas deja dans le stock de ce magasin
        $articles = collect(DB::select("call getArticlesForStock(" . $p_id_magasin . "); "));
        //dump($articles);

        if ($articles == null)
            return redirect()->back()->withInput()->with('alert_warning', 'La base de données des articles est vide, veuillez ajouter les articles avant de procéder à la création des stocks.');

        if ($magasin == null)
            return redirect()->back()->withInput()->with('alert_warning', 'Le magasin choisi n\'existe pas .(veuillez choisir un autre magasin.)');

        else
            return view('Espace_Magas.add-stock_Magasin-form')->with(['articles' => $articles, 'magasin' => $magasin]);
    }

    /*****************************************************************************
     * Valider l'ajout des articles au stock d'un magasin
     *****************************************************************************/
    public function submitAddStock()
    {
        //id du magasin
        $id_magasin = request()->get('id_magasin');

        //array des element du formulaire
        $id_article = request()->get('id_article');
        $designation_c = request()->get('designation_c');
        //$quantite    = request()->get('quantite');
        $quantite_min = request()->get('quantite_min');
        $quantite_max = request()->get('quantite_max');

        $alert1 = "";
        $alert2 = "";
        $error1 = false;
        $error2 = false;
        $nbre_articles = 0;

        echo "quantite_min";
        dump($quantite_min);

        echo "id_article";
        dump($id_article);
        return 'a';

        for ($i = 1; $i <= count($id_article); $i++) {
            //verifier si l utilisateur n a pas saisi les quantites min ou Max
            if ($quantite_min[$i] == null || $quantite_max[$i] == null) continue;

            if ($quantite_min[$i] > $quantite_max[$i]) {
                $alert1 = $alert1 . "<li><b>" . $designation_c[$i] . "</b>: Quantite min superieur a la quantité max.";
                $error1 = true;
            }

            if ($quantite_min[$i] <= $quantite_max[$i] && $quantite_min[$i] != null && $quantite_max[$i] != null) {
                $item = new Stock;
                $item->id_magasin = $id_magasin;
                $item->id_article = $id_article[$i];
                $item->quantite = 0;
                $item->quantite_min = $quantite_min[$i];
                $item->quantite_max = $quantite_max[$i];

                try {
                    $item->save();
                    $nbre_articles++;
                } catch (Exception $e) {
                    $error2 = true;
                    $alert2 = $alert2 . "<li>Erreur d'ajout de l'article: <b>" . $designation_c[$i] . "</b> Message d'erreur: " . $e->getMessage() . ". ";
                }
            }
        }

        if ($error1)
            back()->withInput()->with('alert_warning', $alert1);
        if ($error2)
            back()->withInput()->with('alert_danger', $alert2);

        if ($error1 || $error2)
            return redirect()->back()->withInput();
        else {
            if ($nbre_articles > 1)
                return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' aticle.');
            else
                return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' articles.');
        }
    }

    /*****************************************************************************
     * Afficher le formulaire d'alimentation de stock (liste du stock )
     ******************************************************************************/
    public function stockIN($p_id_magasin)
    {
        //procedure pour recuperer le stock d'un magasin
        $data = collect(DB::select("call getStockForSupply(" . $p_id_magasin . ");"));
        $magasin = Magasin::where('id_magasin', $p_id_magasin)->first();

        if ($data->count() == 0)
            return redirect()->back()->withInput()->with('alert_warning', 'Veuillez créer le stock avant de procéder à son alimentation');

        if ($magasin == null)
            return redirect()->back()->withInput()->with('alert_warning', "Le magasin choisi n'existe pas .(veuillez choisir un autre magasin.)");

        else
            return view('Espace_Magas.supply-stock_Magasin-form')->with(['data' => $data, 'magasin' => $magasin]);
    }

    /*****************************************************************************
     * Valider le formulaire d'alimentation de stock
     ******************************************************************************/
    public function submitStockIN()
    {
        $id_magasin = request()->get('id_magasin');
        //array des element du formulaire ******************
        $id_stock = request()->get('id_stock');
        $quantite = request()->get('quantite');
        $id_article = request()->get('id_article');
        //$designation_c = request()->get('designation_c');
        //**************************************************

        //variables ***************************
        $alert1 = "";
        $alert2 = "";
        $error1 = false;
        $error2 = false;
        $nbre_articles = 0;
        //***********************************

        //*********************************
        //verifier que l utilisateur a saisi 1..* quantites, sinn redirect back
        $hasItems = false;
        for ($i = 1; $i <= count($id_stock); $i++) {
            if ($quantite[$i] > 0) {
                $hasItems = true;
                break;
            }
        }
        if (!$hasItems)
            return redirect()->back()->withInput()->with('alert_info', "Vous devez saisir les quantités à alimenter.");
        //**********************************

        //****************************************
        //recuperer la derniere transaction pour en retirer son id
        $lastTransaction = DB::table('transactions')->orderBy('id_transaction', 'desc')->first();

        if ($lastTransaction == null)
            $id = 1;
        else
            $id = $lastTransaction->id_transaction + 1;
        //****************************************

        //**************************************
        //creation de la transation & chercher l id_type_transaction pour l alimentation du stock
        $id_type_transaction_ajouter = Type_transaction::where('libelle', 'ajouter')->get()->first()->id_type_transaction;

        $transaction = new Transaction();
        $transaction->id_transaction = $id;
        $transaction->id_user = 3;    //from variable de session
        $transaction->id_magasin = $id_magasin;
        $transaction->id_type_transaction = $id_type_transaction_ajouter;
        $transaction->id_paiement = null;
        try {
            $transaction->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with("alert_danger", "Erreur de la création de la transacation dans la base de données, veuillez reassayer ultérieurement.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>.");
        }
        //**************************************

        //**************************************
        //Boucle pour traiter chaque article
        for ($i = 1; $i <= count($id_stock); $i++) {

            //verifier si l utilisateur n a pas saisi les quantites
            if ($quantite[$i] == null) continue;

            try {
                //Creation et insertion de trans_article
                $trans_article = new Trans_article();
                $trans_article->id_transaction = $id;
                $trans_article->id_article = $id_article[$i];
                $trans_article->quantite = $quantite[$i];
                $trans_article->save();
                $nbre_articles++;

                //Executer la procedure de modification de stock
                DB::select("call incrementStock(" . $id_stock[$i] . "," . $quantite[$i] . ");");

            } catch (Exception $e) {
                $alert2 = $alert1 . "<li>Erreur,  article: " . getChamp("articles", "id_article", $id_article[$i], "designation_c") . ". Message d'erreur: <b>" . $e->getMessage() . "</b>.";
                $error2 = true;
            }
        }
        //**************************************

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //imprimer un document d ajout au stock

        if ($error1)
            back()->withInput()->with('alert_warning', $alert1);
        if ($error2)
            back()->withInput()->with('alert_danger', $alert2);

        if ($nbre_articles > 1)
            return redirect()->back()->with('alert_success', 'Alimentation de ' . $nbre_articles . ' aticle.');
        else
            return redirect()->back()->with('alert_success', 'Alimentation de ' . $nbre_articles . ' articles.');

    }


}
