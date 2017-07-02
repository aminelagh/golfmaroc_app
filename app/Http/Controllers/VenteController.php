<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Magasin;
use App\Models\Stock;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VenteController extends Controller
{
    public function ventes()
    {
        $data = Vente::all();
        return view('Espace_Magas.liste-ventes')->withData($data);
    }

    public function addVente()
    {
        $data = Stock::where('id_magasin', 1)->get();
        if ($data->isEmpty())
            return redirect()->back()->withAlertWarning("Le stock du magasin est vide, veuillez commencer par l'alimenter.");
        $magasin = Magasin::find(1);
        return view('Espace_Magas.add-vente-form')->withData($data)->withMagasin($magasin);
    }
}
