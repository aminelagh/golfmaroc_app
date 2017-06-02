<?php

namespace App\Http\Controllers;

use Session;
use Sentinel;
use Illuminate\Http\Request;
use \App\Models\Role;
use \App\Models\Role_user;

class AuthController extends Controller
{
    public function login()
    {
        if (!Sentinel::check()) {
            return view('login');
        }

        if (Sentinel::inRole('admin'))
            return redirect()->route('admin.home');//->with('error', 'You are a customer and cannot access to backend section');
        else if (Sentinel::inRole('magas'))
            return redirect()->route('magas.home');
        else if (Sentinel::inRole('direct'))
            return redirect()->route('direct.home');
        else if (Sentinel::inRole('vend'))
            return redirect()->route('vend.home');
        else echo "Error Login AuthController";

    }

    public function submitLogin(Request $request)
    {

        if (request()->has('remember'))
            $user = Sentinel::authenticateAndRemember(request()->all());
        else
            $user = Sentinel::authenticate(request()->all());

        if (Sentinel::check()) {
            Session::put('id_user', $user->id);
            Session::put('id_magasin', $user->id_magasin);
            Session::put('email', $user->email);
            Session::put('nom', $user->nom);
            Session::put('prenom', $user->prenom);

            return $this->redirectToSpace();

        } else return redirect()->back()->with("alert_danger", "<span class=\"glyphicon glyphicon-exclamation-sign\"> login et/ou mot de passe incorrect")->withInput();
    }

    public function logout()
    {
        Sentinel::logout(null, true);
        return redirect()->route('login');
    }

    //permet de rediriger chaque user vers son propre espace apres l authentification
    public function redirectToSpace()
    {
        if (Sentinel::inRole('admin'))
            return redirect()->route('admin.home');
        else if (Sentinel::inRole('direct'))
            return redirect()->route('direct.home');
        else if (Sentinel::inRole('magas'))
            return redirect()->route('magas.home');
        else if (Sentinel::inRole('vend'))
            return redirect()->route('vend.home');
    }
}
