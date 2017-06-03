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
use Mockery\Exception;

class UpdateController extends Controller
{
    //Marque
    public function submitUpdateMarque()
    {
        $id_marque = request()->get('id_marque');
        $libelle = request()->get('libelle');

        if (Marque::ExistForUpdate($id_marque, $libelle))
            return redirect()->back()->withInput()->with('alert_danger', "La marque: <b>" . $libelle . "</b> existe deja.");

        $item = Marque::find($id_marque);
        try {
            $item->update([
                'libelle' => $libelle,
            ]);

            if (request()->hasFile('image')) {
                $file_extension = request()->file('image')->extension();
                $file_name = "marque_" . $id_marque . "." . $file_extension;
                request()->file('image')->move("uploads/images/marques", $file_name);
                $image = "/uploads/images/marques/" . $file_name;
                $item->update(['image' => $image]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "Modification reussie.");
    }

    //Categorie
    public function submitUpdateCategorie()
    {
        $id_categorie = request()->get('id_categorie');
        $libelle = request()->get('libelle');

        if (Categorie::ExistForUpdate($id_categorie, $libelle))
            return redirect()->back()->withInput()->with('alert_danger', "La categorie: <b>" . $libelle . "</b> existe deja.");

        $item = Categorie::find($id_categorie);
        try {
            $item->update([
                'libelle' => $libelle,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "Modification reussie.");
    }

    //Fournisseur
    public function submitUpdateFournisseurAgents()
    {
        //Update Fournisseur:
        $id_fournisseur = request()->get('id_fournisseur');
        $libelle = request()->get('libelle');
        $code = request()->get('code');

        if (Fournisseur::CodeExistForUpdate($id_fournisseur, $code))
            return redirect()->back()->withInput()->with('alert_warning', "Le code: <b>" . $code . "</b> existe déjà.");

        if (Fournisseur::LibelleExistForUpdate($id_fournisseur, $libelle))
            return redirect()->back()->withInput()->with('alert_warning', "Le fournisseur: <b>" . $libelle . "</b> existe déjà.");

        $item = Fournisseur::find($id_fournisseur);
        try {
            $item->update(['libelle' => $libelle,
                'code' => $code,]);
        } catch
        (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        //----------------------------------------------------

        //Update Agents:

        //array des element du formulaire
        $id_agent = request()->get('id_agent');
        $nom = request()->get('nom');
        $prenom = request()->get('prenom');
        $telephone = request()->get('telephone');
        $email = request()->get('email');
        $ville = request()->get('ville');
        $role = request()->get('role');

        //Update each agent
        for ($i = 1; $i <= count($id_agent); $i++) {
            $item = Agent::find($id_agent[$i]);
            try {
                $item->update([
                    'role' => $role[$i],
                    'nom' => $nom[$i],
                    'prenom' => $prenom[$i],
                    'email' => $email[$i],
                    'telephone' => $telephone[$i],
                    'ville' => $ville[$i],
                ]);
            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('alert_danger', "Erreur de modification.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
            }
        }
        return redirect()->back()->with('alert_success', "Modification reussie.");
    }



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
