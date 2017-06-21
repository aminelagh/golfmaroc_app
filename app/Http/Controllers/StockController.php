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

    //afficher le stock du magasin  et du main -------------------------------------------------------------------------
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
        $p_id_magasin = 1;Session::get('id_magasin');
        $data = Stock::where('id_magasin', $p_id_magasin)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Cet element du stock n'existe pas.");

        $magasin = Magasin::find(1);
        $tailles = Taille_article::all();
        return view('Espace_Magas.add-stockIN-form')->withData($data)->withMagasin($magasin)->withTailles($tailles);
    }

    public function submitAddStockIN()
    {
        return Stock::addStockIN(request());
    }
    //------------------------------------------------------------------------------------------------------------------
    //Stock OUT for main magasin ---------------------------------------------------------------------------------------
    public function addStockOUT()
    {
        $p_id_magasin = 1;//Session::get('id_magasin');
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
    //Stock OUT for main magasin ---------------------------------------------------------------------------------------
    public function addStockTransfertOUT($p_id_magasin_destination)
    {
        $data = Stock::where('id_magasin', 1)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Le stock du magasin principal est vide, veuillez commencer par l'alimenter avant de procéder à un transfert.");

        $magasinDestination = Magasin::find($p_id_magasin_destination);
        if ($magasinDestination == null)
            return redirect()->back()->withInput()->withAlertWarning("le magasin choisi n'existe pas.");

        $magasinSource = Magasin::find(1);
        $tailles = Taille_article::all();

        return view('Espace_Magas.add-stockTransfertOUT-form')->withMagasinSource($magasinSource)->withMagasinDestination($magasinDestination)->withData($data)->withTailles($tailles);
    }
    public function submitAddStockTransfertOUT()
    {
        return Stock::addStockTransfertOUT(request());
    }

    public function addStockTransfertIN($p_id_magasin_source)
    {
        $data = Stock::where('id_magasin', $p_id_magasin_source)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("Le stock du magasin principal est vide, veuillez commencer par l'alimenter avant de procéder à un transfert.");

        $magasinSource = Magasin::find($p_id_magasin_source);
        if ($magasinSource == null)
            return redirect()->back()->withInput()->withAlertWarning("le magasin choisi n'existe pas.");

        $magasinDestination = Magasin::find(1);
        $tailles = Taille_article::all();

        return view('Espace_Magas.add-stockTransfertIN-form')->withMagasinSource($magasinSource)->withMagasinDestination($magasinDestination)->withData($data)->withTailles($tailles);
    }

    public function submitAddStockTransfertIN()
    {
        return Stock::addStockTransfertIN(request());
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


}
