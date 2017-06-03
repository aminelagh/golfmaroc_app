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
        $data = Marque::where('id_marque', $p_id)->get()->first();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "La marque choisie n'existe pas.");

        $articles = Article::where('id_marque', $p_id)->where('deleted', false)->where('valide', true)->get();
        return view('Espace_Magas.info-marque')->withData($data)->withArticles($articles);
    }

    public function categorie($p_id)
    {
        $data = Categorie::where('id_categorie', $p_id)->get()->first();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "La categorie choisie n'existe pas.");

        $articles = Article::where('id_categorie', $p_id)->where('deleted', false)->where('valide', true)->get();
        return view('Espace_Magas.info-categorie')->withData($data)->withArticles($articles);
    }

    public function fournisseur($p_id)
    {
        $data = Fournisseur::where('id_fournisseur', $p_id)->get()->first();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "La categorie choisie n'existe pas.");

        $articles = Article::where('id_fournisseur', $p_id)->where('deleted', false)->where('valide', true)->get();
        $agents = Agent::where('id_fournisseur', $p_id)->get();
        return view('Espace_Magas.info-fournisseur')->withData($data)->withArticles($articles)->withAgents($agents);
    }

    public function agent($p_id)
    {
        $data = Agent::where('id_agent', $p_id)->get()->first();
        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'agent choisi n'existe pas.");

        return view('Espace_Magas.info-agent')->withData($data)->withArticles($articles);
    }

    public function article($p_id)
    {
        $data = Article::where('id_article', $p_id)->get()->first();
        $marques = Marque::all();
        $fournisseurs = Fournisseur::all();
        $categories = Categorie::all();

        if ($data == null)
            return redirect()->back()->with('alert_warning', "L'article choisi n'existe pas.");

        return view('Espace_Magas.info-article')->withData($data)->withMarques($marques)->withFournisseurs($fournisseurs)->withCategories($categories);
    }


}
