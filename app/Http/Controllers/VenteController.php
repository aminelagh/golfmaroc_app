<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Magasin;
use App\Models\Mode_paiement;
use App\Models\Panier;
use App\Models\Panier_article;
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

    public function addVenteSimple()
    {
        $data = Stock::where('id_magasin', 1)->get();
        //$data = collect(DB::select("select * from stocks s join articles a on s.id_article = a.id_article join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by quantite desc"));
        //$data = collect(DB::select("select * from stocks s join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by st.quantite desc"));
        //dump($data);

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        $modes = Mode_paiement::all();
        $clients = Client::where('id_magasin',1)->get();
        return view('Espace_Magas.add-vente_simple-form')->withData($data)->withMagasin($magasin)->withModesPaiement($modes)->withClients($clients);
    }

    public function addVenteGros()
    {
        $data = Stock::where('id_magasin', 1)->get();
        //$data = collect(DB::select("select * from stocks s join articles a on s.id_article = a.id_article join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by quantite desc"));
        //$data = collect(DB::select("select * from stocks s join stock_tailles st on st.id_stock = s.id_stock where s.id_magasin=1 order by st.quantite desc"));
        //dump($data);

        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        $modes = Mode_paiement::all();
        $clients = Client::where('id_magasin',1)->get();
        return view('Espace_Magas.add-vente_gros-form')->withData($data)->withMagasin($magasin)->withModesPaiement($modes)->withClients($clients);
    }

    public function submitAddVente()
    {
        dump(request()->all());

        //Delete Panier
        //Panier::deletePanier();

        //variables du formulaires -------------------------------------------------------------------------------------
        $id_magasin = request()->get('id_magasin');
        $id_stocks = request()->get('id_stock');
        $quantiteOUTs = request()->get('quantiteOUT');
        $id_taille_articles = request()->get('id_taille_article');
        $type_vente = request()->get('type_vente');
        $id_client = request()->get('id_client');

        //paiement:
        $id_mode_paiement = request()->get('id_mode_paiement');
        $ref = request()->get('ref');

        //remise:
        $taux_remise = request()->get('taux_remise');
        $raison = request()->get('raison');
        //--------------------------------------------------------------------------------------------------------------

        dump("taux remise: ".$taux_remise);
        dump("raison: ".$raison);

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
            return redirect()->back()->withInput()->withAlertInfo("Remplissez les formulaires.");
        //--------------------------------------------------------------------------------------------------------------
        //return 'a';

        //Creation d'une vente -----------------------------------------------------------------------------------------
        $id_vente = Vente::getNextID();
        if($taux_remise > 0 )
        {
            if(strlen($raison)<=0)
                return redirect()->back()->withInput()->withAlertWarning("Veuillez spécifier la raison de la remise.");
            else
                ;//Vente::createVenteRemise($id_vente, $id_mode_paiement, $ref, $id_client, $taux_remise, $raison);
        }
        else
            ;//Vente::createVente($id_vente, $id_mode_paiement, $ref, $id_client);
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
                        echo "decrement Stock: id_stock: $id_stock, id_taille_article: $id_taille_article, Quantite -: $quantite <br>";
                        //----------------------------------------------------------------------------------

                        //Creer une nouvelle ligne dans: vente_article -----------------------------------------------
                        echo "<li> vente_articles ==> $id_article - id_taille_article: $id_taille_article - quantite: $quantite <br>";
                        //echo "<li> New Panier_article: id_article: $id_article - id_taille_article: $id_taille_article - quantite: $quantite <br>";

                        //----------------------------------------------------------------------------------------------
                    }
                    $i++;
                }
            }
            echo "<hr>";
        }
        //--------------------------------------------------------------------------------------------------------------
        //return redirect()->back()->withAlertSuccess("Sortie de stock effectuée avec succès");
        //return view('Espace_Magas.add-vente_2-form')->withAlertInfo("Un nouveau panier a ete cree.");
        return "Good";//redirect()->route('magas.validerVente');
    }

   /* public function addVentePhase2()
    {
        $id_user = Session::get('id_user');
        $panier = collect(DB::select("select * from paniers where id_user=".$id_user." "))->first();
        $id_panier = $panier->id_panier;
        //$articles = collect(DB::select("select * from panier_articles where id_panier=".$id_panier." "));
        $articles = Panier_article::where('id_panier',$id_panier)->get();
        $magasin = Magasin::find(1);

        return view('Espace_Magas.add-vente_2-form')->withPanier($panier)->withData($articles)->withMagasin($magasin);

    }

    public function submitAddVenteeee()
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
    }*/
}
