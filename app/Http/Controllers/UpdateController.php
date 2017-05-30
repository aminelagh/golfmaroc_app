<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Agent;
use App\Models\Marque;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Article;
use App\Models\Fournisseur;
use App\Models\Categorie;

class UpdateController extends Controller
{
    /********************************************************
     * afficher le formulaire de modification
     ********************************************************/
    public function updateForm($p_table, $p_id)
    {
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();
        $magasins = Magasin::all();
        $roles = Role::all();
        $marques = Marque::all();

        switch ($p_table) {

            case 'users':
                return view('Espace_Admin.update-user-form')->with(['data' => User::find($p_id), 'magasins' => $magasins, 'roles' => $roles]);
                break;
            case 'user_password':
                return view('Espace_Admin.updatePassword-user-form')->with(['data' => User::find($p_id), 'magasins' => $magasins, 'roles' => $roles]);
                break;
            case 'categories':
                return view('Espace_Magas.update-categorie-form')->withData(Categorie::find($p_id));
                break;
            case 'fournisseurs':
                return view('Espace_Magas.update-fournisseur-form')->withData(Fournisseur::find($p_id));
                break;
            case 'agents':
                return view('Espace_Magas.update-agent-form')->withData(Agent::find($p_id))->with('fournisseurs', Fournisseur::all());
                break;
            case 'marques':
                return view('Espace_Magas.update-marque-form')->withData(Marque::find($p_id));
                break;
            case 'magasins':
                return view('Espace_Magas.update-magasin-form')->withData(Magasin::find($p_id));
                break;
            case 'articles':
                return view('Espace_Magas.update-article-form')->with(['data' => Article::find($p_id), 'fournisseurs' => $fournisseurs, 'categories' => $categories, 'marques' => $marques]);
                break;
            default:
                return back()->withInput()->with('alert_warning', 'Erreur de redirection: UpdateController@updateForm($p_table, $p_id).');
        }
    }

    /********************************************************
     * Valider La modification
     ********************************************************/
    public function submitUpdate($p_table)
    {
        switch ($p_table) {
            case 'users':
                return $this->submitUpdateUser();
                break;
            case 'user_password':
                return $this->submitUpdatePasswordUser();
                break;
            case 'magasins':
                return $this->submitUpdateMagasin();
                break;
            case 'marques':
                return $this->submitUpdateMarque();
                break;
            case 'agents':
                return $this->submitUpdateAgent();
                break;
            case 'fournisseurs':
                return $this->submitUpdateFournisseur();
                break;
            case 'categories':
                return $this->submitUpdateCategorie();
                break;
            case 'articles':
                return $this->submitUpdateArticle();
                break;
            default:
                return back()->withInput()->with('alert_warning', 'Erreur de redirection: UpdateController@submitUpdate($p_table)');
                break;
        }
    }



    //Valider la modification d un article
    public function submitUpdateArticle()
    {
        $id_article = request()->get('id_article');
        $item = Article::find($id_article);

        $item->update([
            'id_categorie' => request()->get('id_categorie'),
            'id_fournisseur' => request()->get('id_fournisseur'),
            'id_marque' => request()->get('id_marque'),
            'num_article' => request()->get('num_article'),
            'code_barre' => request()->get('code_barre'),
            'designation_c' => request()->get('designation_c'),
            'designation_l' => request()->get('designation_l'),
            'taille' => request()->get('taille'),
            'couleur' => request()->get('couleur'),
            'sexe' => request()->get('sexe'),
            'prix_achat' => request()->get('prix_achat'),
            'prix_vente' => request()->get('prix_vente')
        ]);

        if (request()->hasFile('image')) {
            $file_extension = request()->file('image')->extension();
            $file_name = "img" . $id_article . "." . $file_extension;
            request()->file('image')->move("uploads/articles", $file_name);
            $image = "/uploads/articles/" . $file_name;
            $item->update(['image' => $image]);
        }

        return redirect()->route('magas.info', ['p_table' => 'articles', 'id' => $id_article])->with('alert_success', "Modification de l'article reussi.");
    }

    //Valider la modification d un Categorie
    public function submitUpdateCategorie()
    {
        $item = Categorie::find(request()->get('id_categorie'));
        $item->update([
            'libelle' => request()->get('libelle'),
            'description' => request()->get('description')
        ]);
        return redirect()->route('magas.info', ['p_table' => 'categories', 'p_id' => request()->get('id_categorie')])->with('alert_success', 'Modification du fournisseur reussi.');
    }

    //Valider la modification d un agent
    public function submitUpdateAgent()
    {
        $item = Agent::find(request()->get('id_agent'));
        $item->update([
            'id_fournisseur' => request()->get('id_fournisseur'),
            'nom' => request()->get('nom'),
            'prenom' => request()->get('prenom'),
            'email' => request()->get('email'),
            'role' => request()->get('role'),
            'telephone' => request()->get('telephone')
        ]);
        return redirect()->route('magas.info', ['p_table' => 'agents', 'p_id' => request()->get('id_agent')])->with('alert_success', "Modification de l'agent reussi.");
    }

    //Valider la modification d un marque
    public function submitUpdateMarque()
    {
        $item = Marque::find(request()->get('id_marque'));
        $item->update([
            'libelle' => request()->get('libelle'),
            'description' => request()->get('description')
        ]);
        return redirect()->route('magas.info', ['p_table' => 'marques', 'p_id' => request()->get('id_marque')])->with('alert_success', "Modification de la marque <b>" . request()->get('libelle') . "</b> reussi.");
    }

    //Valider la modification d un fournisseur
    public function submitUpdateFournisseur()
    {
        $item = Fournisseur::find(request()->get('id_fournisseur'));
        $item->update([
            'code' => request()->get('code'),
            'libelle' => request()->get('libelle'),
            'description' => request()->get('description')
        ]);
        return redirect()->route('magas.info', ['p_table' => 'fournisseurs', 'id' => request()->get('id_fournisseur')])->with('alert_success', 'Modification du fournisseur reussi.');
    }

    //Valider la modification d un Magasin
    public function submitUpdateMagasin()
    {
        /*if (Magasin::Exists('libelle', request()->get('libelle')))
            return redirect()->back()->withInput()->with("alert_warning", "Le magasin <b>" . request()->get('libelle') . "</b> existe déjà.");*/

        $item = Magasin::find(request()->get('id_magasin'));
        $item->update([
            'libelle' => request()->get('libelle'),
            'ville' => request()->get('ville'),
            'agent' => request()->get('agent'),
            'email' => request()->get('email'),
            'telephone' => request()->get('telephone'),
            'adresse' => request()->get('adresse'),
            'description' => request()->get('description')
        ]);
        return redirect()->route('magas.info', ['p_tables' => 'magasins', 'id' => request()->get('id_magasin')])->with('alert_success', 'Modification du magasin reussi.');
    }


}
