<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Magasin;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Marque;
use App\Models\Stock;
use App\Models\Promotion;
use \Exception;

class DeleteController extends Controller
{

    /******************************************
     * Fonction pour effacer une ligne d'une table
     *******************************************/
    public function delete($p_table, $p_id)
    {
        try {
            switch ($p_table) {
                case 'categories':
                    $item = Categorie::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]); //$item->delete();

                        return back()->withInput()->with('alert_success', "La catégorie a été effacée avec succès");
                    } else {
                        return back()->withInput()->with('alert-warning', "La catégorie choisie n'existe pas.");
                    }
                    break;
                case 'users':
                    $item = User::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]);
                        return back()->withInput()->with('alert_success', "L'utilisateur a été effacé avec succès");
                    } else {
                        return back()->withInput()->with('alert-warning', "L'utilisateur choisi n'existe pas.");
                    }
                    break;
                case 'fournisseurs':
                    $item = Fournisseur::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]);
                        return back()->withInput()->with('alert_success', "Le fournisseur a été effacé avec succès");
                    } else {
                        return back()->withInput()->with('alert-warning', "Le fournisseur choisi n'existe pas.");
                    }
                    break;
                case 'articles':
                    $item = Article::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]);
                        return back()->withInput()->with('alert_success', "L'article a été effacé avec succès");
                    } else {
                        return back()->withInput()->with('alert-warning', "L'article choisi n'existe pas.");
                    }
                    break;
                case 'magasins':
                    $item = Magasin::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]);

                        return back()->withInput()->with('alert_success', "Le magasin a été effacé avec succès");
                    } else {
                        return back()->withInput()->with('alert-warning', "Le magasin choisi n'existe pas.");
                    }
                    break;
                case 'stocks':
                    $item = Stock::find($p_id);
                    if ($item != null) {
                        $item->delete();
                        return back()->withInput()->with('alert_success', "L'element du stock a été effacé avec succès.");
                    } else {
                        return back()->withInput()->with('alert-warning', "L'element du stock choisi n'existe pas.");
                    }
                    break;
                case 'promotions':
                    $item = Promotion::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]);
                        return back()->withInput()->with('alert_success', "La promotion a été effacée avec succès.");
                    } else {
                        return back()->withInput()->with('alert-warning', "La promotion choisie n'existe pas.");
                    }
                    break;
                case 'marques':
                    $item = Marque::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]);
                        return back()->withInput()->with('alert_success', "La marque a été effacée avec succès");
                    } else {
                        return back()->withInput()->with('alert-warning', "La marque choisie n'existe pas.");
                    }
                    break;
                case 'agents':
                    $item = Agent::find($p_id);
                    if ($item != null) {
                        $item->update(['deleted' => true]);
                        return back()->withInput()->with('alert_success', "L'agent a été effacé avec succès");
                    } else {
                        return back()->withInput()->with('alert-warning', "L'agent choisi n'existe pas.");
                    }
                    break;
                default:
                    return back()->withInput()->with('alert_danger', "Probleme de redirection. DeleteController@delete");
                    break;
            }
        } catch (Exception $ex) {
            return back()->with('alert_danger', "Erreur de suppression.<br>Message d'erreur: <b>" . $ex->getMessage() . ", code: (" . $ex->getCode() . ").</b>");
        }
    }


}
