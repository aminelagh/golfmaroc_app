<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Marque;
use Illuminate\Http\Request;
use Mockery\Exception;

class MagasController extends Controller
{
    public function home()
    {
        return view('Espace_Magas.dashboard');
    }

    /***************************************************
     *************** Gestion des Articles **************
     ***************************************************/

    /********************************************************
     * Afficher les listes
     *********************************************************/
    public function marques()
    {
        $data = Marque::where('deleted', false)->get();
        return view('Espace_Magas.liste-marques')->withData($data);
    }

    public function categories()
    {
        $data = Categorie::where('deleted', false)->get();
        return view('Espace_Magas.liste-categories')->withData($data);
    }

    public function fournisseurs()
    {
        $data = Fournisseur::where('deleted', false)->get();
        return view('Espace_Magas.liste-fournisseurs')->withData($data);
    }

    public function agents()
    {
        $data = Agent::where('deleted', false)->get();
        return view('Espace_Magas.liste-agents')->withData($data);
    }

    public function articles()
    {
        $data = Article::where('deleted', false)->get();
        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();

        return view('Espace_Magas.liste-articles')->withData($data);
    }
    /******************************************************************************************************************/

    /********************************************************
     * Afficher les infos
     *********************************************************/
    public function marque($p_id)
    {
        $data = Marque::where('id_marque',$p_id)->get()->first();
        $articles = Article::where('id_marque',$p_id)->where('deleted',false)->where('valide',true)->get();
        return view('Espace_Magas.info-marque')->withData($data)->withArticles($articles);
    }


}
