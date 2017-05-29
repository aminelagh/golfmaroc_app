<?php

namespace App\Http\Controllers;

use Sentinel;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Input;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Agent;
use App\Models\Marque;
use App\Models\Promotion;
use Carbon\Carbon;
use \Exception;

class AddController extends Controller
{

    /********************************************************
     * Afficher le formulaire d'ajout pour tt les tables
     *********************************************************/
    public function addForm($p_table)
    {
        switch ($p_table) {
            case 'users':
                return view('Espace_Admin.add-user-form')->with( [ 'magasins' => Magasin::all(), 'roles' => Role::all()]);
                break;
            case 'agents':
                return view('Espace_Magas.add-agent-form')->with('fournisseurs', Fournisseur::all());
                break;
            case 'marques':
                return view('Espace_Magas.add-marque-form');//->with('data', Marque::all() );
                break;
            case 'categories':
                return view('Espace_Magas.add-categorie-form')->withData(Categorie::all());
                break;
            case 'fournisseurs':
                return view('Espace_Magas.add-fournisseur-form');//->withData(Fournisseur::all())->withAgents(Agent::all());
                break;
            case 'magasins':
                return view('Espace_Magas.add-magasin-form')->withData(Magasin::all());
                break;
            case 'articles':
                return view('Espace_Magas.add-article-form')->with(['data' => Article::all(), 'fournisseurs' => Fournisseur::all(), 'categories' => Categorie::all(), 'marques' => Marque::all()]);
                break;
            case 'promotions':
                return view('Espace_Direct.add-promotions-form')->with(['articles' => Article::all(), 'fournisseurs' => Fournisseur::all(), 'categories' => Categorie::all(), 'magasins' => Magasin::all()]);
                break;
            default:
                return redirect()->back()->withInput()->with('alert_warning', 'Le formulaire d\'ajout choisi n\'existe pas.');
                break;
        }
    }

    /********************************************************
     * Valider L'ajout: Fonction de principale
     *********************************************************/
    public function submitAdd($p_table)
    {
        switch ($p_table) {
            case 'magasins':
                return $this->submitAddMagasin();
                break;
            case 'fournisseurs':
                return $this->submitAddFournisseur();
                break;
            case 'categories':
                return $this->submitAddCategorie();
                break;
            case 'marques':
                return $this->submitAddMarque();
                break;
            case 'agents':
                return $this->submitAddAgent();
                break;
            case 'articles':
                return $this->submitAddArticle();
                break;
            case 'stocks':
                return "AddController@submitAdd";//$this->submitAddStock();
                break;
            case 'users':
                return $this->submitAddUser();
                break;
            case 'promotions':
                return $this->submitAddPromotions();
                break;
            default:
                return redirect()->back()->withInput()->with("alert_warning", "<strong>Erreur !!</strong> Vous avez pris le mauvais chemin. ==> AddController@submitAdd");
                break;
        }
    }

    //Valider l'ajout d un utilisateur
    public function submitAddUser()
    {
        //creation d'un Directeur a partir des donnees du formulaire:
        /*$item = new User();
        //$item->id_role = request()->get('id_role');
        $item->id_magasin = request()->get('id_magasin');
        $item->nom = request()->get('nom');
        $item->prenom = request()->get('prenom');
        $item->ville = request()->get('ville');
        $item->telephone = request()->get('telephone');
        $item->email = request()->get('email');
        $item->password = Hash::make(request()->get('password'));
        $item->deleted = false;
        $credentials = [
            'id_magasin' => request()->get('id_magasin'),
            'nom' => request()->get('nom'),
            'prenom' => request()->get('prenom'),
            'ville' => request()->get('ville'),
            'telephone' => request()->get('telephone'),
            'email' => request()->get('email'),
            'password' => request()->get('password'),
            'deleted' => false
        ];*/

        //return redirect()->back()->withInput()->with('alert_warning',"aaaaaaaaaaaaaaaaaaaaa");

        //si l'email exist deja alors revenir au formulaire avec les donnees du formulaire et un message d'erreur
        if (User::EmailExist(request()->get('email') ) )
            return redirect()->back()->withInput()->with("alert_danger", "<li><i>" . request()->get('email') . "</i> est deja utilisé.");

        //si le mot de passe et trop court:
        if (strlen(request()->get('password')) < 7)
            return redirect()->back()->withInput()->with("alert_danger", "<li>Mot de Passe trop court.");

        try {
            $user = Sentinel::registerAndActivate(request()->all());
            $role = Sentinel::findRoleById(request()->get('id_role'));
            $role->users()->attach($user);

        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with("alert_danger", "l'ajout de " . request()->get('email') . " a echoue. <br> message d'erreur: " . $ex->getMessage() . ".");
        }

        return redirect()->back()->with('alert_success', "ajout de  <strong>" . request()->get('email') . "</strong>  reussi");
    }

    //Valider l'ajout de : Magasin
    public function submitAddMagasin()
    {
        if (Magasin::Exists('libelle', request()->get('libelle')))
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
            return redirect()->back()->withInput()->with('alert_danger', "Erreur d'ajout du magasin <b>".request()->get('libelle')."</b>.<br> Message d'erreur: <b>".$e->getMessage()."</b>.");
        }
        return redirect()->back()->with('alert_success', "Le Magasin <b>" . request()->get('libelle') . "</b> a bien été ajouté");

    }

    //Valider l'ajout d'un agent
    public function submitAddAgent()
    {
        $item = new Agent;
        $item->id_fournisseur = request()->get('id_fournisseur');
        $item->email = request()->get('email');
        $item->nom = request()->get('nom');
        $item->prenom = request()->get('prenom');
        $item->role = request()->get('role');
        $item->telephone = request()->get('telephone');
        $item->deleted = false;
        try {
            $item->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "L'ajout de l'agent <b>" . request()->get('libelle') . "</b> a échoué. <br> message d'erreur: " . $e->getMessage() . ".");
        }
        return redirect()->back()->with('alert_success', "L'agent <b>" . request()->get('nom') . " " . request()->get('prenom') . "</b> a bien été ajouté");

    }

    //Valider l'ajout de : Categorie
    public function submitAddCategorie()
    {
        if (request()->get('libelle') == null)
            return redirect()->back()->withInput()->with('alert_danger', "Veuillez remplir le champ <b>Categorie</b>");

        if (Categorie::Exists('libelle', request()->get('libelle')))
            return redirect()->back()->withInput()->with('alert_danger', "La categorie <b>" . request()->get('libelle') . "</b> existe déjà.");

        $item = new Categorie;
        $item->libelle = request()->get('libelle');
        $item->description = request()->get('description');
        $item->deleted = false;
        try {
            $item->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with('alert_danger', "L'ajout de la categorie: " . request()->get('libelle') . " a echoué. <br>message d'erreur: " . $ex->getMessage() . ".");
        }
        return redirect()->back()->with('alert_success', "Création de la catégorie " . request()->get('libelle') . " réussie.");
    }

    //Valider l'ajout de : Marque
    public function submitAddMarque()
    {
        if (request()->get('libelle') == null)
            return redirect()->back()->withInput()->with('alert_danger', "veuillez remplir le champ libelle");

        if (Marque::Exists('libelle', request()->get('libelle')))
            return redirect()->back()->withInput()->with('alert_warning', "La marque <b>" . request()->get('libelle') . "</b> existe déjà.");

        $item = new Marque;
        $item->libelle = request()->get('libelle');
        $item->description = request()->get('description');
        $item->deleted = false;
        try {
            $item->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur d'ajout de la marque <b>" . request()->get('libelle') . "</b><br/>Message d'erreur: <b>" . $ex->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', 'La Categorie <strong>' . request()->get('libelle') . '</strong> a bien été ajouté.');
    }

    //Valider l'ajout de Fournisseur
    public function submitAddFournisseur()
    {
        if (request()->get('libelle') == null)
            return redirect()->back()->withInput()->with('alert_danger', "Veuillez remplir le champ <b>libelle</b>.");
        if (request()->get('code') == null)
            return redirect()->back()->withInput()->with('alert_danger', "Veuillez remplir le champ <b>Code</b>.");

        if (Fournisseur::Exists('code', request()->get('code')))
            return redirect()->back()->withInput()->with('alert_danger', "Un fournisseur avec le code <b>" . request()->get('code') . "</b> existe déjà.");

        if (Fournisseur::Exists('libelle', request()->get('libelle')))
            return redirect()->back()->withInput()->with('alert_danger', "Le fournisseur <b>" . request()->get('libelle') . "</b>  existe déjà.");


        $item = new Fournisseur;
        $item->code = request()->get('code');
        $item->libelle = request()->get('libelle');
        $item->description = request()->get('description');
        $item->deleted = false;

        try {
            $item->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with('alert_danger', "L'ajout du fournisseur: " . request()->get('libelle') . " a echoue. <br> message d'erreur: " . $ex->getMessage() . " ");
        }
        return redirect()->back()->with('alert_success', 'Le Fournisseur <strong>' . request()->get('code') . ': ' . request()->get('libelle') . '</strong> a bien été ajouté.');

    }

    //Valider l'ajout de : Magasin
    public function submitAddArticle()
    {
        $alerts1 = "";
        $alerts2 = "";
        $error1 = false;
        $error2 = false;

        if (Article::Exists('num_article', request()->get('num_article'))) {
            return redirect()->back()->withInput()->with('alert_warning', "le numero " . request()->get('num_article') . " est deja utilisé pour un autre article");
        }

        $id_article = Article::getNextID();

        $item = new Article;
        $item->id_article = $id_article;
        $item->id_categorie = request()->get('id_categorie');
        $item->id_fournisseur = request()->get('id_fournisseur');
        $item->id_marque = request()->get('id_marque');
        $item->num_article = request()->get('num_article');
        $item->code_barre = request()->get('code_barre');
        $item->designation_c = request()->get('designation_c');
        $item->designation_l = request()->get('designation_l');
        $item->taille = request()->get('taille');
        $item->sexe = request()->get('sexe');
        $item->couleur = request()->get('couleur');
        $item->prix_achat = request()->get('prix_achat');
        $item->prix_vente = request()->get('prix_vente');
        $item->deleted = false;
        $item->valide = false;

        if (request()->hasFile('image')) {
            $file_extension = request()->file('image')->extension();
            //$file_size = request()->file('image')->getSize();
            $file_name = "img" . $id_article . "." . $file_extension;
            request()->file('image')->move("uploads/articles", $file_name);
            $item->image = "/uploads/articles/" . $file_name;
        } else {
            $item->image = false;
        }

        /*if (request()->has('force') && request()->get('force') == "true") {
            if (Exists('articles', 'designation_c', request()->get('designation_c'))) {
                $alerts1 = $alerts1 . "<li>L\'article <i>" . request()->get('designation_c') . "</i> existe déjà.";
                $error1 = true;
            }
            if (Exists('articles', 'num_article', request()->get('num_article'))) {
                $alerts1 = $alerts1 . "<li>Le numero: <i>" . request()->get('num_article') . "</i> est deja utilise pour un autre article.";
                $error1 = true;
            }
            try {
                $item->save();
            } catch (Exception $ex) {
                return redirect()->back()->withInput()->with('alert_danger', '<li>Une erreur s\'est produite lors de l\'ajout de l\'article.<br>Message d\'erreur: ' . $ex->getMessage());
            }

            if ($error1)
                redirect()->back()->with('alert-info', $alerts1);

            return redirect()->back()->with('alert_success', 'L\'article <strong>' . request()->get('designation_c') . '</strong> a bien été ajouté.');
        }
        else
        if (Exists('articles', 'designation_c', request()->get('designation_c'))) {
            $alerts1 = $alerts1 . "<li>L'article <i>" . request()->get('designation_c') . "</i> existe déjà.";
            $error1 = true;
        }

        if (Exists('articles', 'num_article', request()->get('num_article'))) {
            $alerts1 = $alerts1 . "<li>Le numero: <i>" . request()->get('num_article') . "</i> est deja utilisé pour un autre article.";
            $error1 = true;
        }
        if (Exists('articles', 'code_barre', request()->get('code_barre'))) {
            $alerts1 = $alerts1 . "<li>Le code: <i>" . request()->get('code') . "</i> est deja utilisé pour un autre article.";
            $error1 = true;
        }
        if (request()->get('prix_vente') == null) {
            $alerts2 = $alerts2 . "<li>Veuillez remplir le champ: <i>Prix de vente</i>";
            $error2 = true;
        }
        if (request()->get('prix_achat') == null) {
            $alerts2 = $alerts2 . "<li>Veuillez remplir le champ: <i>Prix d'achat</i>";
            $error2 = true;
        }

        if (request()->get('couleur') == null) {
            $alerts2 = $alerts2 . "<li>Veuillez remplir le champ: <i>Couleur</i>";
            $error2 = true;
        }

        redirect()->back()->withInput()->with('alert_info', $alerts1);
        redirect()->back()->withInput()->with('alert_warning', $alerts2);
    */
        //if ($error1 || $error2) return redirect()->back()->withInput()->with('alert_success', "vous pouvez forcer l'ajout en cochant la case en dessous du formulaire.");

        try {
            $item->save();
        } catch (Exception $ex) {
            return redirect()->back()->withInput()->with('alert_danger', "Une erreur s'est produite lors de l'ajout de l'article.<br>Message d'erreur: " . $ex->getMessage());
        }

        return redirect()->back()->with('alert_success', "L'article <b>" . request()->get('designation_c') . "</b> a bien été ajouté.");

    }

    //Valider la creation des promotions
    public function submitAddPromotions()
    {

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
