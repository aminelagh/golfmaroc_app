<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Exception;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use Session;

class AdminController extends Controller
{
    //afficher la page d'accueil
    public function home()
    {
        return view('Espace_Admin.dashboard');
    }

    //Afficher le profil de l'administrateur pour modification
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

    //valider la modification d'un utilisateur
    public function updateProfile()
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

    //Valider la modification de user password
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

    public function listeUsers()
    {
        $data = User::where('id','!=',Session::get('id_user'))->whereDeleted(false)->orWhere('deleted', null)->get();
        return view('Espace_Admin.liste-users')->with('data', $data);
    }


    //permet de retourner la vue qui contient le formulaire d'ajout
    public function addFormUser()
    {
        $magasins = DB::table('magasins')->get();
        $roles = DB::table('roles')->get();
        return view('Espace_Admin.add-user-form')->with(['magasins' => $magasins, 'roles' => $roles]);
    }

    //supprimer utilisateur
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.lister')->with('alert_success', 'l\'Utilisateur a bien été effacé.');
    }


}
