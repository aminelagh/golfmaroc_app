<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Stock;
use App\Models\Vente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VenteController extends Controller
{
    public function ventes()
    {
        $data = Vente::all();
        return view('Espace_Magas.liste-ventes')->withData($data);
    }

    public function addVente()
    {
        $data = Stock::where('id_magasin', 1)->get();
        //$data = collect(DB::select("select * from stocks s join articles a on s.id_article = a.id_article join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by quantite desc"));
        //$data = collect(DB::select("select * from stocks s join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by st.quantite desc"));
        //dump($data);

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        return view('Espace_Magas.add-vente-form')->withData($data)->withMagasin($magasin);
    }

    public function submitAddVentePhase1()
    {
        if (request()->has('type_prix'))
            echo "vente de gros";
        else echo "vente simple";

        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin = request()->get('id_magasin');
        $id_stocks = request()->get('id_stock');
        $quantiteOUTs = request()->get('quantiteOUT');
        $id_taille_articles = request()->get('id_taille_article');
        //--------------------------------------------------------------------------------------------------------------

        //verifier la validitee des donnees ----------------------------------------------------------------------------
        $hasData = false;
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteOUTs[$id_stock])) {
                $i = 1;
                foreach ($quantiteOUTs[$id_stock] as $quantiteOUT) {
                    if ($quantiteOUT != null && $quantiteOUT > 0) {
                        $hasData = true;
                    }
                    $i++;
                }
            }
        }
        if (!$hasData)
            echo "No data<hr>"; //return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires dans les onglets <b>Stock</b>");
        //--------------------------------------------------------------------------------------------------------------

        //Creation d'une transaction -----------------------------------------------------------------------------------
        //$id_transaction = Transaction::getNextID();
        //Transaction::createTransactionOUT($id_transaction);
        echo "<li>creer Panier.<br>";
        //--------------------------------------------------------------------------------------------------------------

        //Creation des trans_articles ----------------------------------------------------------------------------------
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteOUTs[$id_stock])) {
                $stock = Stock::find($id_stock);
                $i = 1;
                foreach ($quantiteOUTs[$id_stock] as $quantite) {
                    if ($quantite != null && $quantite != 0) {
                        $id_taille_article = $id_taille_articles[$id_stock][$i];
                        $id_article = Stock::getIdArticle($id_stock);

                        //decrementer le stock -------------------------------------------------------------
                        //Stock_taille::decrementer($id_stock, $id_taille_articles[$id_stock][$i], $quantite);
                        //----------------------------------------------------------------------------------

                        //Creer une nouvelle ligne dans: panier_articles -----------------------------------------------
                        echo "<li> New Panier_article: id_article: $id_article - id_taille_article: $id_taille_article - quantite: $quantite <br>";
                        //----------------------------------------------------------------------------------------------
                    }
                    $i++;
                }
            }
            echo "<hr>";
        }
        //--------------------------------------------------------------------------------------------------------------
        //return redirect()->back()->withAlertSuccess("Sortie de stock effectuée avec succès");
    }

    public function submitAddVentePhase()
    {
        dump(request()->all());

        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin = request()->get('id_magasin');
        $id_stocks = request()->get('id_stock');
        $quantiteOUTs = request()->get('quantiteOUT');
        $quantite = request()->get('quantite');
        $prix_gros = request()->get('type_prix');
        $id_taille_articles = request()->get('id_taille_article');
        //--------------------------------------------------------------------------------------------------------------

        echo "$prix_gros<hr>";
        //verifier la validitee des donnees ----------------------------------------------------------------------------
        $hasData = false;
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteOUTs[$id_stock])) {
                $i = 1;
                foreach ($quantiteOUTs[$id_stock] as $quantiteOUT) {
                    if ($quantiteOUT != null && $quantiteOUT > 0) {
                        $hasData = true;
                    }
                    $i++;
                }
            }
        }
        if (!$hasData)
            echo "<li> =====> non data => return back()<br>";//return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires dans les onglets <b>Stock</b>");
        //--------------------------------------------------------------------------------------------------------------

        //Creation d'un panier -----------------------------------------------------------------------------------
        //$id_transaction = Transaction::getNextID();
        //Transaction::createTransactionOUT($id_transaction);

        //--------------------------------------------------------------------------------------------------------------

        $data = [];//array_add(['name' => 'Desk'], 'price', 100);

        //Creation des trans_articles ----------------------------------------------------------------------------------
        //pour chaque id_stock / id_article
        foreach ($id_stocks as $id_stock) {
            if (isset($quantiteOUTs[$id_stock])) {

                $stock = Stock::find($id_stock);
                dump("--> id_stock: " . $stock->id_stock . " - id_article: " . $stock->id_article . " - id_magasin: " . $stock->id_magasin . " ");
                $i = 1;

                //pour chaque taille_article / quantite
                foreach ($quantiteOUTs[$id_stock] as $quantite) {
                    if ($quantite != null && $quantite != 0) {
                        $id_taille_article = $id_taille_articles[$id_stock][$i];

                        echo "<li>Stock_taille::decrementer($id_stock, $id_taille_article, $quantite)";
                        echo "<br>==> id_article: " . Stock::getIdArticle($id_stock) . " , id_taille_article: $id_taille_article , quantite: $quantite<br>";

                    }
                    $i++;
                }
            }
            echo "<hr>";
        }
        //--------------------------------------------------------------------------------------------------------------
        //return redirect()->back()->withAlertSuccess("Sortie de stock effectuée avec succès");
    }
}
