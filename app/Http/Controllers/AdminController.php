<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use \Exception;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Marque;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\Input;
use Session;
use Sentinel;

class AdminController extends Controller
{

    public function home()
    {
        return view('Espace_Admin.dashboard');
    }

    /********************************************************
     * afficher et modifier le profile et mot de passe de l admin
     **********************************************************/
    //Profile -----------------------------------------------------
    public function profile()
    {
        $data = User::where('id', Session::get('id_user'))->get()->first();
        //dump($data);
        return view('Espace_Admin.profile')->with('data', $data);
    }

    public function updatePassword()
    {
        $data = User::where('id', Session::get('id_user'))->get()->first();
        //dump($data);
        return view('Espace_Admin.profile-password')->with('data', $data);
    }

    public function submitUpdateProfile()
    {
        if (User::EmailExistForUpdate(request()->get('email')))
            return redirect()->back()->withInput()->with('alert_danger', "L'email: <b>" . request()->get('email') . "</b> est deja utilisé pour un autre utilisateur.");

        else {
            $item = User::find(request()->get('id_user'));
            try {
                $item->update([
                    'nom' => request()->get('nom'),
                    'prenom' => request()->get('prenom'),
                    'ville' => request()->get('ville'),
                    'telephone' => request()->get('telephone'),
                    'telephone' => request()->get('telephone'),
                    'email' => request()->get('email')
                ]);
                User::updateSession(request()->get('id_user'));

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification de votre profile.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
            }
            return redirect()->route('admin.profile')->with('alert_success', "Modification de votre Profile reussi.");
        }
    }

    public function submitUpdatePassword()
    {
        if (strlen(request()->get('password')) < 8)
            return redirect()->back()->withInput()->with('alert_danger', "Le mot de passe doit contenir, au moins, 7 caractères.");

        $item = User::find(request()->get('id_user'));
        try {
            $item->update([
                'password' => Hash::make(request()->get('password'))
            ]);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification du mot de passe.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->route('admin.profile')->with('alert_success', "Modification du mot de passe reussi.");
    }
    //--------------------------------------------------------------

    //Users---------------------------------------------------------
    public function addUser()
    {
        $magasins = Magasin::all();
        $roles = Role::all();
        return view('Espace_Admin.add-user-form')->with(['magasins' => $magasins, 'roles' => $roles]);
    }

    public function submitAddUser()
    {
        $email = request()->get('email');
        $password = request()->get('password');
        $nom = request()->get('nom');
        $prenom = request()->get('prenom');
        $ville = request()->get('ville');
        $telephone = request()->get('telephone');
        $id_magasin = request()->get('id_magasin');
        $role_name = request()->get('role_name');

        if (User::EmailExist($email))
            return redirect()->back()->withInput(request()->except(['password']))->with('alert_warning', "L'email: <b>" . $email . "</b> existe deja.");

        $credentials = [
            'email' => $email,
            'password' => $password,
            'nom' => $nom,
            'prenom' => $prenom,
            'ville' => $ville,
            'telephone' => $telephone,
            'id_magasin' => $id_magasin,
            'deleted' => false,
        ];
        try {

            $user = Sentinel::registerAndActivate($credentials);
            $role = Sentinel::findRoleByName($role_name);
            $role->users()->attach($user);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de creation de l'utilisateur.<br>Meessage d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->back()->with('alert_success', "Creation de l'utilisateur <b>" . $nom . " " . $prenom . "</b> reussi.");


    }

    public function listeUsers()
    {
        $data = User::where('id', '!=', Session::get('id_user'))->whereDeleted(false)->orWhere('deleted', null)->get();
        return view('Espace_Admin.liste-users')->with('data', $data);
    }

    public function infoUser($p_id)
    {
        if (Session::get('id_user') == $p_id)
            return redirect()->back();

        $data = User::where('id', $p_id)->first();
        $magasins = Magasin::all();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'utilisateur choisit n'esxiste pas.");

        return view('Espace_Admin.info-user')->withData($data)->withMagasins($magasins);
    }

    public function submitUpdateUser()
    {
        if (User::EmailExistForUpdateUser(request()->get('email'), request()->get('id_user')))
            return redirect()->back()->withInput()->with('alert_danger', "L'email: <b>" . request()->get('email') . "</b> est deja utilisé pour un autre utilisateur.");

        else {
            $user_id = request()->get('id_user');
            $item = User::find($user_id);
            try {
                $item->update([
                    'nom' => request()->get('nom'),
                    'prenom' => request()->get('prenom'),
                    'ville' => request()->get('ville'),
                    'telephone' => request()->get('telephone'),
                    'email' => request()->get('email')
                ]);

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification de l'utilisateur. <br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
            }
            return redirect()->route('admin.user', ['p_id' => $user_id])->with('alert_success', "Modification de l'utilisateur reussi.");
        }
    }

    public function updateUserPassword($p_id)
    {
        if (Session::get('id_user') == $p_id)
            return redirect()->back();

        $data = User::where('id', $p_id)->first();
        $magasins = Magasin::all();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'utilisateur choisi n'existe pas.");

        return view('Espace_Admin.updatePassword-user-form')->withData($data);
    }

    public function submitUpdateUserPassword()
    {
        if (strlen(request()->get('password')) < 8)
            return redirect()->back()->withInput()->with('alert_danger', "Le mot de passe doit contenir, au moins, 7 caractères.");

        $id_user = request()->get('id_user');

        $item = User::find($id_user);
        try {
            $item->update([
                'password' => Hash::make(request()->get('password'))
            ]);

        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification du mot de passe.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
        }
        return redirect()->route('admin.user', ['p_id' => $id_user])->with('alert_success', "Modification du mot de passe reussi.");
    }
    //---------------------------------------------------------------

    //Articles ------------------------------------------------------
    public function articles_nv()
    {
        $data = Article::nonValideArticles();
        if($data->isEmpty())
            return redirect()->back()->withInput()->with('alert_warning',"Aucun nouvel article a valider");
        return view('Espace_Admin.liste-articles_nv')->withData($data);
    }

    public function articles()
    {
        $data = Article::all();
        return view('Espace_Admin.liste-articles')->withData($data);
    }

    public function submitArticlesValide()
    {
        //return 'a';
        //array des element du formulaire ******************
        $valide = request()->get('valide');
        $id_article = request()->get('id_article');
        //**************************************************

        if ($valide == null)
            return redirect()->back()->withInput()->with('alert_info', "Veuillez cocher les articles valides.");

        $nbreArticles = 0;

        //Boucle pour traiter chaque article ***************
        for ($i = 1; $i <= count($id_article); $i++) {
            if (isset($valide[$i])) {
                if ($valide[$i] == $i) {
                    $item = Article::find($id_article[$i]);
                    try {
                        $nbreArticles++;
                        $item->update([
                            'valide' => true,
                        ]);

                    } catch (Exception $e) {
                        return redirect()->back()->withInput()->with('alert_danger', "Erreur de validation des articles.<br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
                    }
                }
            }
        }

        if ($nbreArticles == 1)
            return redirect()->back()->with('alert_success', "Modification reussie de $nbreArticles artticle.");
        else if ($nbreArticles > 1)
            return redirect()->back()->with('alert_success', "Modification reussie de $nbreArticles articles.");
        else return redirect()->back()->withInput();


        //****************************************************
    }

    public function article_nv($p_id)
    {
        $data = Article::where('id_article', $p_id)->where('valide', false)->get()->first();

        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'article choisi n'existe pas ou il a déjà été validé.");

        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();


        return view('Espace_Admin.info-article')->withData($data)->withMarques($marques)->withFournisseurs($fournisseurs)->withCategories($categories);
    }

    public function submitUpdateArticle()
    {
        $id_article = request()->get('id_article');
        $code = request()->get('code');

        if (Article::CodeExistForUpdate($id_article, $code))
            return redirect()->back()->withInput()->with('alert_warning', "Le code: <b>" . $code . "</b> est deja utilisé pour un autre article.");

        else {
            $item = Article::find($id_article);
            try {
                $item->update([
                    'id_categorie' => request()->get('id_categorie'),
                    'id_marque' => request()->get('id_marque'),
                    'id_fournisseur' => request()->get('id_fournisseur'),

                    'code' => request()->get('code'),
                    'ref' => request()->get('ref'),
                    'alias' => request()->get('alias'),

                    'designation' => request()->get('designation'),

                    'couleur' => request()->get('couleur'),
                    'sexe' => request()->get('sexe'),

                    'prix_a' => request()->get('prix_a'),
                    'prix_v' => request()->get('prix_v'),

                    'valide' => true,
                ]);

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('alert_danger', "Erreur de Modification de l'article. <br>Message d'erreur: <b>" . $e->getMessage() . "</b>");
            }
            return redirect()->route('admin.articles_nv')->with('alert_success', "Modification de l'utilisateur reussi.");
        }
    }
    //---------------------------------------------------------------


}
