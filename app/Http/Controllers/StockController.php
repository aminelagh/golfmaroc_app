<?php

namespace App\Http\Controllers;

use App\Models\Stock_taille;
use App\Models\Taille_article;
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
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
    public function stock($p_id)
    {
        return "StcckController@stock(id)";
        $data = Stock_taille::where('id_stock', $p_id)->get();
        $magasin = Magasin::find($p_id);

        if ($data->isEmpty())
            return redirect()->route('magas.addStockIN', ['p_id' => $p_id])->withAlertInfo("Cet article n'est pas disponible dans le stock. Vous pouvez commencer par l'alimenter.");
        //return redirect()->back()->withInput()->withAlertInfo("Cet article n'est pas disponible dans le stock.");
        else
            return view('Espace_Magas.info-stock')->withData($data)->withMagasin($magasin);
    }

    //afficher le stock du main magasin --------------------------------------------------------------------------------
    public function main_stocks()
    {
        $data = Stock::where('id_magasin', 1)->get();
        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin principal est vide, vous devez le créer.")->withRouteWarning('/magas/addStock/' . 1);
        else
            return view('Espace_Magas.liste-main_stocks')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }

    //afficher le stock du magasin
    public function stocks($p_id)
    {
        if ($p_id == 1)
            return redirect()->back()->withInput()->withAlertInfo("Vous ne pouvez pas accéder à ce magasin de cette manière.");

        $data = Stock::where('id_magasin', $p_id)->get();
        $magasin = Magasin::find($p_id);
        $tailles = Taille_article::all();

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock de ce magasin est vide, vous pouvez commencer par le créer.")->withRouteWarning('/magas/addStock/' . $p_id);
        else
            return view('Espace_Magas.liste-stocks')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }
    //------------------------------------------------------------------------------------------------------------------

    //Creation du stock de tt les magasins -----------------------------------------------------------------------------
    public function addStock($p_id)
    {
        $magasin = Magasin::find($p_id);
        $articles = collect(DB::select("call getArticlesForStock(" . $p_id . "); "));

        if ($magasin == null)
            return redirect()->back()->withInput()->with('alert_warning', "Le magasin choisi n'existe pas.");

        if ($articles == null)
            return redirect()->back()->withInput()->with('alert_warning', "La base de données des articles est vide, veuillez ajouter les articles avant de procéder à la création des stocks.");

        return view('Espace_Magas.add-stock-form')->withMagasin($magasin)->withArticles($articles);
    }

    public function submitAddStock(Request $request)
    {
        return Stock::addStock($request);

        /*
                //array des element du formulaire
                $id_article = request()->get('id_article');
                $designation = request()->get('designation');
                $quantite_min = request()->get('quantite_min');
                $quantite_max = request()->get('quantite_max');

                $error = "";
                $alert2 = "";
                $hasError = false;
                $error2 = false;
                $nbre_articles = 0;

                for ($i = 1; $i <= count($id_article); $i++) {
                    //verifier si l utilisateur n a pas saisi les quantites min ou Max
                    if ($quantite_min[$i] == null || $quantite_max[$i] == null) continue;

                    if ($quantite_min[$i] >= $quantite_max[$i])
                    {
                        $hasError = true;
                        $error = $error."<li>Quantite min > Quantite max pour l'article numero $i: <b>" . $designation[$i] . "</b>";
                        //return redirect()->back()->withInput()->withAlertWarning("Quantite min > Quantite max pour l'article numero $i: <b>" . $designation[$i] . "</b>")->withalignWarning("right")->withTimerWarning(6000);
                    }


                    if ($quantite_min[$i] <= $quantite_max[$i]) {
                        $item = new Stock;
                        $item->id_magasin = $id_magasin;
                        $item->id_article = $id_article[$i];
                        $item->quantite_min = $quantite_min[$i];
                        $item->quantite_max = $quantite_max[$i];

                        try {
                            //$item->save();
                            $nbre_articles++;
                        } catch (Exception $e) {
                            $alert2 = $alert2 . "<li>Erreur d'ajout de l'article: <b>" . $designation[$i] . "</b> <br>Message d'erreur: " . $e->getMessage() . ". ";
                        }
                    }
                }


                if ($hasError)
                    return redirect()->back()->withInput()->withAlertWarning($error)->withalignWarning("right")->withTimerWarning(10000);
                else {
                    if ($nbre_articles > 1)
                        return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' article.');
                    else
                        return redirect()->back()->with('alert_success', 'Ajout de ' . $nbre_articles . ' articles.');
                }*/
    }
    //------------------------------------------------------------------------------------------------------------------

    //Stock IN for main magasin ----------------------------------------------------------------------------------------
    public function addStockIN()
    {
        $p_id_magasin = Session::get('id_magasin');
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data == null)
            return redirect()->back()->withInput()->withAlertWarning("Cet element du stock n'existe pas.");

        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();
        return view('Espace_Magas.add-stockIN-form')->withMagasin($magasin)->withData($data)->withTailles($tailles);
    }

    public function submitAddStockIN()
    {
        return Stock::addStockIN(request());
    }
    //------------------------------------------------------------------------------------------------------------------
    //Stock OUT for main magasin ----------------------------------------------------------------------------------------
    public function addStockOUT()
    {
        $p_id_magasin = Session::get('id_magasin');
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data == null)
            return redirect()->back()->withInput()->withAlertWarning("Cet element du stock n'existe pas.");

        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();
        return view('Espace_Magas.add-stockOUT-form')->withMagasin($magasin)->withData($data)->withTailles($tailles);
    }

    public function submitAddStockOUT()
    {
        return Stock::addStockOUT(request());
    }
    //------------------------------------------------------------------------------------------------------------------
    //Stock OUT for main magasin ----------------------------------------------------------------------------------------
    public function addStockTransfertIN($p_id_magasin_source)
    {
        $source = Magasin::find($p_id_magasin_source);
        $destination = Magasin::find(1);
        echo "magasin source: ".$source->id_magasin." -> ".$source->libelle;
        echo "<br>";
        echo "magasin destination: ".$destination->id_magasin." -> ".$destination->libelle;

        return '.';

        $p_id_magasin = Session::get('id_magasin');
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data == null)
            return redirect()->back()->withInput()->withAlertWarning("Cet element du stock n'existe pas.");

        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();
        return view('Espace_Magas.add-stockOUT-form')->withMagasin($magasin)->withData($data)->withTailles($tailles);
    }
    public function addStockTransfertOUT($p_id_magasin_destination)
    {
        $destination = Magasin::find($p_id_magasin_destination);
        $source = Magasin::find(1);
        echo "magasin source: ".$source->id_magasin." -> ".$source->libelle;
        echo "<br>";
        echo "magasin destination: ".$destination->id_magasin." -> ".$destination->libelle;

        return '.';
    }

    public function submitAddStockTransfert()
    {
        //return Stock::addStockTransfert(request());
    }
    //------------------------------------------------------------------------------------------------------------------

    /*****************************************************************************
     * Lister Stocks
     *****************************************************************************/
    public function listerStocks($p_id_magasin)
    {
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->with('alert_warning', "Le stock de ce magasin est vide.");
        else
            return view('Espace_Magas.liste-stocks')->with('data', $data);
    }

    /*****************************************************************************
     * Afficher le fomulaire d'ajout pour le stock
     *****************************************************************************/
    public function addStockaa($p_id_magasin)
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
     * Afficher le formulaire d'alimentation de stock (liste du stock )
     ******************************************************************************/
    public function stockIN($p_id)
    {
        return 'StockController@StockIN';

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

    public function StockOUT($p_id)
    {
        return 'StockController@StockOUT';
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
