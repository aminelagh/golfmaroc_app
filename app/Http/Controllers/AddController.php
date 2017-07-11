<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Magasin;
use App\Models\Marque;
use App\Models\Promotion;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Input;

class AddController extends Controller
{
    public function addClient()
    {
        return view('Espace_Magas.add-client-form');
    }

    public function addMarque()
    {
        return view('Espace_Magas.add-marque-form');
    }

    public function addMagasin()
    {
        return view('Espace_Magas.add-magasin-form');
    }

    public function addCategorie()
    {
        return view('Espace_Magas.add-categorie-form');
    }

    public function addFournisseur()
    {
        return view('Espace_Magas.add-fournisseur-form');
    }

    public function addAgent()
    {
        $fournisseurs = Fournisseur::all();
        return view('Espace_Magas.add-agent-form')->withFournisseurs($fournisseurs);
    }

    public function addAgentFournisseur($p_id)
    {
        $fournisseur = Fournisseur::where('id_fournisseur', $p_id)->get()->first();
        if ($fournisseur == null)
            return redirect()->back()->withInput()->with('alert_warning', "Le fournisseur choisi n'existe pas.");
        return view('Espace_Magas.add-agentFournisseur-form')->withFournisseur($fournisseur);
    }

    public function addArticle()
    {
        $fournisseurs = Fournisseur::all();
        $marques = Marque::all();
        $categories = Categorie::all();
        return view('Espace_Magas.add-article-form')->withFournisseurs($fournisseurs)->withMarques($marques)->withCategories($categories);
    }

    public function addPromotions()
    {
        $data = Article::where('valide', true)->where('deleted', false)->get();
        if ($data->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("veuillez creer des articles avant de proceder a la creation des promotions.");

        $magasins = Magasin::where('deleted', false)->get();
        if ($magasins->isEmpty())
            return redirect()->back()->withInput()->withAlertWarning("veuillez creer des magasins avant de proceder a la creation des promotions.");

        return view('Espace_Admin.add-promotion-form')->with(['data' => $data, 'magasins' => $magasins]);
    }

    //------------------------------------------------------------------------------------------------------------------
    public function submitAddClient()
    {
        $nom = request()->get('nom');
        $prenom = request()->get('prenom');
        if (Client::Exists($nom, $prenom))
            return redirect()->back()->withInput()->with('alert_warning', "le client <b>" . $nom . " " . $prenom . "</b> existe deja.");

        $age = request()->get('age');
        $ville = request()->get('ville');
        $sexe = request()->get('sexe');

        $item = new Client;
        $item->id_magasin = Session::get('id_magasin');
        $item->nom = $nom;
        $item->prenom = $prenom;
        $item->ville = $ville;
        $item->age = $age;
        $item->sexe = $sexe;
        $item->deleted = false;

        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de creation du client.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "Le client <b>" . $nom . " " . $prenom . "</b> a bien été créer");
    }

    public function submitAddMarque()
    {
        $libelle = request()->get('libelle');
        if (Marque::Exists($libelle))
            return redirect()->back()->withInput()->with('alert_warning', "la marque <b>" . $libelle . "</b> existe deja.");

        $id_marque = Marque::getNextID();

        $item = new Marque;
        $item->id_marque = $id_marque;
        $item->libelle = $libelle;
        $item->deleted = false;

        if (request()->hasFile('image')) {
            $file_extension = request()->file('image')->extension();
            //$file_size = request()->file('image')->getSize();
            $file_name = "marque_" . $id_marque . "." . $file_extension;
            request()->file('image')->move("uploads/images/marques", $file_name);
            $item->image = "/uploads/images/marques/" . $file_name;
        } else {
            $item->image = false;
        }

        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de creation de la marque.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "La marque <b>" . request()->get('libelle') . "</b> a bien été créer");
    }

    public function submitAddCategorie()
    {
        $libelle = request()->get('libelle');
        if (Categorie::Exists($libelle))
            return redirect()->back()->withInput()->with('alert_warning', "la categorie <b>" . $libelle . "</b> existe deja.");

        $item = new Categorie();
        $item->libelle = $libelle;
        $item->deleted = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de creation de la categorie.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "La categorie <b>" . request()->get('libelle') . "</b> a bien été créer");
    }

    public function submitAddFournisseur()
    {
        $libelle = request()->get('libelle');
        $code = request()->get('code');

        if (Fournisseur::CodeExists($code))
            return redirect()->back()->withInput()->with('alert_warning', "le code <b>" . $code . "</b> est déjà utilisé pour un autre fournisseur.");

        if (Fournisseur::LibelleExists($libelle))
            return redirect()->back()->withInput()->with('alert_warning', "le fournisseur <b>" . $libelle . "</b> exist déjà.");

        $item = new Fournisseur();
        $item->libelle = $libelle;
        $item->code = $code;
        $item->deleted = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de creation de la categorie.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "La categorie <b>" . request()->get('libelle') . "</b> a bien été créer");
    }

    public function submitAddAgent()
    {
        $item = new Agent;
        $item->id_fournisseur = request()->get('id_fournisseur');
        $item->email = request()->get('email');
        $item->nom = request()->get('nom');
        $item->prenom = request()->get('prenom');
        $item->role = request()->get('role');
        $item->ville = request()->get('ville');
        $item->telephone = request()->get('telephone');
        $item->deleted = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "L'ajout de l'agent <b>" . request()->get('libelle') . "</b> a échoué. <br> message d'erreur: " . $e->getMessage() . ".");
        }
        return redirect()->back()->with('alert_success', "L'agent <b>" . request()->get('nom') . " " . request()->get('prenom') . "</b> a bien été ajouté");

    }

    public function submitAddArticle()
    {
        $id_categorie = request()->get('id_categorie');
        $id_marque = request()->get('id_marque');
        $id_fournisseur = request()->get('id_fournisseur');
        $ref = request()->get('ref');
        $alias = request()->get('alias');
        $code = request()->get('code');
        $designation = request()->get('designation');
        $sexe = request()->get('sexe');
        $couleur = request()->get('couleur');
        $prix_a = request()->get('prix_a');
        $prix_v = request()->get('prix_v');


        if (Article::CodeExists($code)) {
            return redirect()->back()->withInput()->with('alert_warning', "le code " . $code . " est deja utilisé pour un autre article");
        }

        $id_article = Article::getNextID();

        $item = new Article;
        $item->id_article = $id_article;
        $item->id_categorie = $id_categorie;
        $item->id_fournisseur = $id_fournisseur;
        $item->id_marque = $id_marque;
        $item->code = $code;
        $item->ref = $ref;
        $item->alias = $alias;
        $item->designation = $designation;
        $item->sexe = $sexe;
        $item->couleur = $couleur;
        $item->prix_a = $prix_a;
        $item->prix_v = $prix_v;
        $item->deleted = false;
        $item->valide = false;

        //upload Image
        if (request()->hasFile('image')) {
            $file_extension = request()->file('image')->extension();
            //$file_size = request()->file('image')->getSize();
            $file_name = "article_" . $id_article . "." . $file_extension;
            request()->file('image')->move("uploads/images/articles", $file_name);
            $item->image = "/uploads/images/articles/" . $file_name;
        } else {
            $item->image = false;
        }

        try {
            $item->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with('alert_danger', "Une erreur s'est produite lors de l'ajout de l'article.<br>Message d'erreur: " . $ex->getMessage());
        }

        return redirect()->back()->with('alert_success', "L'article <b>" . request()->get('designation_c') . "</b> a bien été ajouté.");

    }

    public function submitAddMagasin()
    {
        $libelle = request()->get('libelle');
        if (Magasin::Exists($libelle))
            return redirect()->back()->withInput()->with("alert_warning", "Le magasin <b>" . request()->get('libelle') . "</b> existe déjà.");

        $item = new Magasin;
        $item->libelle = request()->get('libelle');
        $item->email = request()->get('email');
        $item->agent = request()->get('agent');
        $item->ville = request()->get('ville');
        $item->telephone = request()->get('telephone');
        $item->adresse = request()->get('adresse');
        $item->deleted = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur d'ajout du magasin <b>" . request()->get('libelle') . "</b>.<br> Message d'erreur: <b>" . $e->getMessage() . "</b>.");
        }
        return redirect()->back()->with('alert_success', "Le Magasin <b>" . request()->get('libelle') . "</b> a bien été ajouté");

    }


    //Valider la creation des promotions
    public function submitAddPromotions()
    {
        dump(request()->all());
        return 'a';

        $id_article = request()->get('id_article');
        $id_magasin = request()->get('id_magasin');
        $taux = request()->get('taux');
        $date_debut = request()->get('date_debut');
        $date_fin = request()->get('date_fin');

        $alert1 = "";
        $alert2 = "";
        $error1 = false;
        $error2 = false;
        $nbre_articles = 0;

        for ($i = 1; $i <= count($id_article); $i++) {
            if ($taux[$i] == 0 || $taux[$i] == null || $date_debut[$i] == null || $date_fin[$i] == null || $id_magasin[$i] == 0) continue;

            $dd = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($date_debut[$i])));
            $df = Carbon::createFromFormat('d-m-Y', date('d-m-Y', strtotime($date_fin[$i])));

            //skip if EndDate < BeginDate
            if ($dd->year > $df->year) continue;
            elseif ($dd->month > $df->month) continue;
            elseif ($dd->day > $df->day) continue;

            $item = new Promotion;
            $item->id_article = $id_article[$i];
            $item->id_magasin = $id_magasin[$i];
            $item->taux = $taux[$i];
            $item->date_debut = $date_debut[$i];
            $item->date_fin = $date_fin[$i];
            $item->active = true;

            try {
                $item->save();
                $nbre_articles++;
            } catch (Exception $e) {
                $error2 = true;
                $alert2 = $alert2 . "<li>Erreur de l'ajout de l'article numero " . $i . ": <br>Message d'erreur: " . $e->getMessage();
            }

        }

        if ($error1)
            back()->withInput()->with('alert_warning', $alert1);
        if ($error2)
            back()->withInput()->with('alert_danger', $alert2);

        return redirect()->back()->with('alert_success', 'Creation des promotions reussite. nbre articles: ' . $nbre_articles);
    }


}
