<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\Trans_Article;
use App\Models\Type_transaction;
use App\Models\Mode_paiement;
use App\Models\Promotion;
use App\Models\Remise;
use App\Models\Paiement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use \Exception;

class VendeurController extends Controller

//Afficher la page d'acceuil de l'Espace Vendeur
{
    public function home()
    {
        Session::put('id_magasin', 1);
        Session::put('id_user', 1);

        return view('Espace_Vend.dashboard');
    }

    //Lister les ventes,les promotions et le stock du magasin
    public function lister($p_table, $p_id)
    {
        $id_magasin = Session::get('id_user'); //variable de session ici
        $id_user = Session::get('id_magasin');//Variable de session ici

        switch ($p_table) {
            case 'transactions':
                $data = collect(DB::select("call getVentesUser(" . $id_user . ");"));
                return view('Espace_Vend.liste-transactions')->with('data', $data);
                break;
            case 'trans_articles':
                $data = collect(DB::select("call getTrans_Articles(" . $p_id . ");"));
                if ($data->isEmpty())
                    return redirect()->back()->withInput()->with("alert_warning", "cette vente n'a pas de detail.");
                else {
                    $total = 0;
                    foreach ($data as $item) {
                        $total += ($item->prix) * $item->quantite;
                    }
                    return view('Espace_Vend.liste-trans_articles')->with(['data' => $data, 'total' => $total]);
                }
                break;
            case 'ventes':
                $data = collect(DB::select("call getVentesMagasin(" . $p_id . ");"));
                return view('Espace_Vend.liste-ventes')->with('data', $data);
                break;
            case 'promotions':
                $data = collect(DB::select("call getPromotionsForMagasin(" . $id_magasin . "); "));
                return view('Espace_Vend.liste-promotions')->with('data', $data);
                break;
            case 'stocks':
                $data = collect(DB::select("call getStockOfMagasin(" . $id_magasin . "); "));
                //$data = Stock::where('id_magasin',$p_id)->get();  dump($data);
                return view('Espace_Vend.liste-stocks')->with('data', $data);
                break;
            default:
                return redirect()->back()->withInput()->with('alert_warning', "Erreur de redirection. VendeurController@lister");
                break;
        }
    }




    // afficher le formulaire de creation de vente
    public function addFormVente()
    {
        $p_id_magasin = Session::get('id_magasin');

        $data = collect(DB::select("call getStockOfMagasin(" . $p_id_magasin . "); "));
        $modes_paiement = Mode_paiement::all();

        if ($data == null)
            return redirect()->back()->withInput()->with("alert_warning", "Le stock de votre magasin est vide, veuillez faire une demande d'alimentation du stock pour procéder avec les ventes.");

        else
            return view('Espace_Vend.add-vente-form')->with(['data' => $data, 'modes_paiement' => $modes_paiement]);
    }


    // Valider l'ajout des ventes
    public function submitAddVente()
    {
        $x = new Remise();

        $id_magasin = Session::get('id_magasin');

        //array des element du formulaire ******************
        $id_stock = request()->get('id_stock');
        $quantite = request()->get('quantite');
        $id_article = request()->get('id_article');
        //**************************************************

        //not array ******************************
        $id_mode_paiement = request()->get('id_mode_paiement');
        $ref = request()->get('ref');
        $taux_remise = request()->get('taux_remise');
        $raison = request()->get('raison');
        //****************************************

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
            if ($quantite[$i] != null) {
                $hasItems = true;
                break;
            }
        }
        if (!$hasItems)
            return redirect()->back()->withInput($_REQUEST)->with('alert_info', "Vous devez saisir les quantités à alimenter.");
        //**********************************

        $id_type_transaction_vendre = Type_transaction::where('libelle', 'vendre')->get()->first()->id_type_transaction;

        $id_transaction = Transaction::getNextID();//recuperer la derniere transaction pour en retirer son id
        $transaction = new Transaction();
        $transaction->id_transaction = $id_transaction;
        $transaction->id_user = Session::get('id_user');    //from variable de session
        $transaction->id_magasin = Session::get('id_magasin');
        $transaction->id_type_transaction = $id_type_transaction_vendre;
        $transaction->annulee = false;

        //creation de la remise (si dispo) ***************
        if ($taux_remise != null) {
            $id_remise = Remise::getNextID();   //methode static dans models/Remise, pour recuperer l id suivant

            //creer la remise et l inserer
            $remise = new Remise();
            $remise->creer($id_remise, $taux_remise, $raison);
            //*************************************************
            $transaction->id_remise = $id_remise;   //insert id_remise dans transaction

        } else {
            $transaction->id_remise = null;
        }
        //*************************************************

        //Ceer le paiement: *******************************
        $id_paiement = Paiement::getNextID();

        $paiement = new Paiement();
        $paiement->creer($id_paiement,$id_mode_paiement,$ref);
        $transaction->id_paiement = $id_paiement;
        //*************************************************

        //creer la transaction ****************************
        try{
            $transaction->save();
        }catch(Exception $e){return redirect()->back()->withInput()->with("alert_danger", "Erreur de la création de la transacation dans la base de données, veuillez reassayer ultérieurement.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>.");}
        //*************************************


        //Boucle pour traiter chaque article **********************************************
        for ($i = 1; $i <= count($id_stock); $i++) {

            //verifier si l utilisateur n a pas saisi les quantites
            if ($quantite[$i] == null || $quantite[$i] == 0) continue;

            try {
                //Creation et insertion de trans_article
                $trans_article = new Trans_article();
                $trans_article->id_transaction = $id_transaction;
                $trans_article->id_article = $id_article[$i];
                $trans_article->quantite = $quantite[$i];

                $prix_article = Article::getPrixPromo($id_article[$i], $id_magasin);    //appliquer la promotion si disponible.
                //appliquer la remise si disponible
                if ($taux_remise != null) {
                    $prix_article = $prix_article*(1-$taux_remise/100);
                }

                $trans_article->prix = $prix_article;
                $trans_article->save();
                $nbre_articles++;
                DB::select("call decrementStock(" . $id_stock[$i] . "," . $quantite[$i] . ");");

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('alert_danger',"Erreur de creation du $i eme article.<br> Message d'erreur: ".$e->getMessage());
                //$alert2 = $alert1 . "<li>Erreur,  article: " . getChamp("articles", "id_article", $id_article[$i], "designation_c") . ". Message d'erreur: <b>" . $e->getMessage() . "</b>.";
                //$error2 = true;
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
            return redirect()->back()->with('alert_success', 'Vente de ' . $nbre_articles . ' aticle.');
        else
            return redirect()->back()->with('alert_success', 'Vente de ' . $nbre_articles . ' articles.');

    }

}
