<?php


Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/facture', function () {

    $view = "pdf.pdf-facture";
    $pdf = PDF::loadView($view);
    return $pdf->stream('facture.pdf');

    $data = null;
    $mergeData = null;
    $encoding = "UTF-8";

    $pdf = PDF::loadView($view);
    //$pdf = PDF::loadView($view, $data, $mergeData, $encoding);
    //$pdf->setPaper("A4", 'portrait');
    return $pdf->stream('facture.pdf');


    //$vente = \App\Models\Vente::where('id_vente', 1)->get()->first();
    //$vente_articles = \App\Models\Vente_article::where('id_vente', 1)->get();

    return $pdf->stream('Facture ' . date('d-M-Y') . '.pdf');


    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();

});

Route::get('/session', function () {
    dump(session()->all());
});


/***************************************
 * Magas routes protected by adminMiddleware
 ****************************************/
Route::group(['middleware' => 'magas'], function () {

    Route::get('/magas', 'MagasController@home')->name('magas.home');

    //Magasin ----------------------------------------------------------------------------------------------------------
    Route::get('/magas/magasins', 'MagasController@magasins')->name('magas.magasins');
    Route::get('/magas/magasin', 'MagasController@main_magasin')->name('magas.main_magasin');
    Route::get('/magas/magasin/{p_id?}', 'MagasController@magasin')->name('magas.magasin');
    Route::get('/magas/addMagasin', 'AddController@addMagasin')->name('magas.addMagasin');
    Route::post('/magas/submitAddMagasin', 'AddController@submitAddMagasin')->name('magas.submitAddMagasin');
    Route::post('/magas/submitUpdateMagasin', 'UpdateController@submitUpdateMagasin')->name('magas.submitUpdateMagasin');
    //------------------------------------------------------------------------------------------------------------------
    //Main-Magasin -----------------------------------------------------------------------------------------------------
    //afficher le stock du magasin principal
    Route::get('/magas/stocks', 'StockController@main_stocks')->name('magas.main_stocks');
    Route::get('/magas/stocks/{p_id?}', 'StockController@stocks')->name('magas.stocks');

    //afficher un article du stock en detail
    Route::get('/magas/stock/{p_id}', 'StockController@stock')->name('magas.stock');

    //creer le stock....................................................................................................
    Route::get('/magas/addStock/{p_id}', 'StockController@addStock')->name('magas.addStock');
    Route::post('/magas/submitAddStock', 'StockController@submitAddStock')->name('magas.submitAddStock');
    //..................................................................................................................

    //main magasin stock IN et OUT .....................................................................................
    Route::get('/magas/addStockIN', 'StockController@addStockIN')->name('magas.addStockIN');
    Route::get('/magas/addStockOUT', 'StockController@addStockOUT')->name('magas.addStockOUT');
    Route::post('/magas/submitAddStockIN', 'StockController@submitAddStockIN')->name('magas.submitAddStockIN');
    Route::post('/magas/submitAddStockOUT', 'StockController@submitAddStockOUT')->name('magas.submitAddStockOUT');
    //..................................................................................................................

    //Transferer stock .................................................................................................
    Route::get('/magas/addStockTransfertOUT', 'StockController@addStockTransfertOUTall')->name('magas.addStockTransfertOUT');//transfert out vers any magasin
    Route::get('/magas/addStockTransfertIN/{p_id_magasin_source}', 'StockController@addStockTransfertIN')->name('magas.addStockTransfertIN');//Transfert IN depuis un magasin X
    Route::get('/magas/addStockTransfertOUT/{p_id_magasin_destination?}', 'StockController@addStockTransfertOUT')->name('magas.addStockTransfertOUT');//transfert out vers un magasin X
    Route::post('/magas/submitAddStockTransfertIN', 'StockController@submitAddStockTransfertIN')->name('magas.submitAddStockTransfertIN');
    Route::post('/magas/submitAddStockTransfertOUT', 'StockController@submitAddStockTransfertOUT')->name('magas.submitAddStockTransfertOUT');
    //..................................................................................................................

    //Transactions .....................................................................................................
    Route::get('/magas/entrees', 'TransactionController@entrees')->name('magas.entrees');
    Route::get('/magas/entree/{p_id}', 'TransactionController@entree')->name('magas.entree');
    Route::get('/magas/sorties', 'TransactionController@sorties')->name('magas.sorties');
    //..................................................................................................................
    //------------------------------------------------------------------------------------------------------------------


    //Vente ------------------------------------------------------------------------------------------------------------
    Route::get('/magas/ventes', 'VenteController@ventes')->name('magas.ventes');
    Route::get('/magas/vente/{p_id}', 'VenteController@vente')->name('magas.vente');
    Route::get('/magas/addVenteSimple', 'VenteController@addVenteSimple')->name('magas.addVenteSimple');
    Route::get('/magas/addVenteGros', 'VenteController@addVenteGros')->name('magas.addVenteGros');
    Route::post('/magas/submitAddVente', 'VenteController@submitAddVente')->name('magas.submitAddVente');

    //Client ...........................................................................................................
    Route::get('/magas/clients', 'MagasController@clients')->name('magas.clients');
    Route::get('/magas/client/{p_id}', 'MagasController@client')->name('magas.client');
    Route::get('/magas/addClient', 'AddController@addClient')->name('magas.addClient');
    Route::post('/magas/submitAddClient', 'AddController@submitAddClient')->name('magas.submitAddClient');
    Route::post('/magas/submitUpdateClient', 'UpdateController@submitUpdateClient')->name('magas.submitUpdateClient');
    //------------------------------------------------------------------------------------------------------------------

    //Promotion --------------------------------------------------------------------------------------------------------
    Route::get('/magas/promotions', 'MagasController@promotions')->name('magas.promotions');
    Route::get('/magas/promotion/{p_id}', 'MagasController@promotion')->name('magas.promotion');
    Route::get('/magas/addPromotion', 'AddController@addPromotion')->name('magas.addPromotion');
    Route::post('/magas/submitAddPromotion', 'AddController@submitAddPromotion')->name('magas.submitAddPromotion');
    Route::post('/magas/submitUpdatePromotion', 'UpdateController@submitUpdatePromotion')->name('magas.submitUpdatePromotion');
    //------------------------------------------------------------------------------------------------------------------
    //Marque -----------------------------------------------------------------------------------------------------------
    Route::get('/magas/marques', 'MagasController@marques')->name('magas.marques');
    Route::get('/magas/marque/{p_id}', 'MagasController@marque')->name('magas.marque');
    Route::get('/magas/addMarque', 'AddController@addMarque')->name('magas.addMarque');
    Route::post('/magas/submitAddMarque', 'AddController@submitAddMarque')->name('magas.submitAddMarque');
    Route::post('/magas/submitUpdateMarque', 'UpdateController@submitUpdateMarque')->name('magas.submitUpdateMarque');
    //------------------------------------------------------------------------------------------------------------------
    //Categorie --------------------------------------------------------------------------------------------------------
    Route::get('/magas/categories', 'MagasController@categories')->name('magas.categories');
    Route::get('/magas/categorie/{p_id}', 'MagasController@categorie')->name('magas.categorie');
    Route::get('/magas/addCategorie', 'AddController@addCategorie')->name('magas.addCategorie');
    Route::post('/magas/submitAddCategorie', 'AddController@submitAddCategorie')->name('magas.submitAddCategorie');
    Route::post('/magas/submitUpdateCategorie', 'UpdateController@submitUpdateCategorie')->name('magas.submitUpdateCategorie');
    //------------------------------------------------------------------------------------------------------------------
    //Fournisseur ------------------------------------------------------------------------------------------------------
    Route::get('/magas/fournisseurs', 'MagasController@fournisseurs')->name('magas.fournisseurs');
    Route::get('/magas/fournisseur/{p_id}', 'MagasController@fournisseur')->name('magas.fournisseur');
    Route::get('/magas/addFournisseur', 'AddController@addFournisseur')->name('magas.addFournisseur');
    Route::get('/magas/addAgentFournisseur/{p_id}', 'AddController@addAgentFournisseur')->name('magas.addAgentFournisseur');

    Route::post('/magas/submitAddAgent', 'AddController@submitAddAgent')->name('magas.submitAddAgent');
    Route::post('/magas/submitAddFournisseur', 'AddController@submitAddFournisseur')->name('magas.submitAddFournisseur');
    Route::post('/magas/submitUpdateFournisseurAgents', 'UpdateController@submitUpdateFournisseurAgents')->name('magas.submitUpdateFournisseurAgents');
    //------------------------------------------------------------------------------------------------------------------
    //Agent ------------------------------------------------------------------------------------------------------------
    //Route::get('/magas/agents', 'MagasController@agents')->name('magas.agents');
    Route::get('/magas/agent/{p_id}', 'MagasController@agent')->name('magas.agent');
    //Route::get('/magas/addAgent', 'AddController@addAgent')->name('magas.addAgent');
    //Route::post('/magas/submitUpdateAgent', 'UpdateController@submitUpdateAgent')->name('magas.submitUpdateAgent');
    //------------------------------------------------------------------------------------------------------------------
    //Article ----------------------------------------------------------------------------------------------------------
    Route::get('/magas/articles', 'MagasController@articles')->name('magas.articles');
    Route::get('/magas/article/{p_id}', 'MagasController@article')->name('magas.article');
    Route::get('/magas/addArticle', 'AddController@addArticle')->name('magas.addArticle');
    Route::post('/magas/submitAddArticle', 'AddController@submitAddArticle')->name('magas.submitAddArticle');
    Route::post('/magas/submitUpdateArticle', 'UpdateController@submitUpdateArticle')->name('magas.submitUpdateArticle');
    //------------------------------------------------------------------------------------------------------------------

});

/***************************************
 * Admin routes protected by adminMiddleware
 ****************************************/
Route::group(['middleware' => 'admin'], function () {

    //Afficher la page d'accueil ==> Admin
    Route::get('/admin', 'AdminController@home')->name('admin.home');

    //turn it into post
    Route::get('/admin/delete/users/{p_id}', 'AdminController@deleteUsers')->name('admin.delete.users');
    Route::get('/admin/delete/promotions/{p_id}', 'DeleteController@deletePromotions')->name('admin.delete.promotions');


    //Profile ----------------------------------------------------------------------------------------------------------
    Route::get('/admin/profile', 'AdminController@profile')->name('admin.profile');
    Route::get('/admin/updatePassword', 'AdminController@updatePassword')->name('admin.updatePassword');
    Route::post('/admin/submitUpdateProfile', 'AdminController@submitUpdateProfile')->name('admin.submitUpdateProfile');
    Route::post('/admin/submitUpdatePassword', 'AdminController@submitUpdatePassword')->name('admin.submitUpdatePassword');
    //------------------------------------------------------------------------------------------------------------------
    //Users-------------------------------------------------------------------------------------------------------------
    Route::get('/admin/users', 'AdminController@listeUsers')->name('admin.users');
    Route::get('/admin/user/{p_id}', 'AdminController@infoUser')->name('admin.user');
    Route::get('/admin/addUser', 'AdminController@addUser')->name('admin.addUser');
    Route::post('/admin/submitAddUser', 'AdminController@submitAddUser')->name('admin.submitAddUser');
    Route::post('/admin/submitUpdateUser', 'AdminController@submitUpdateUser')->name('admin.submitUpdateUser');
    Route::get('/admin/updateUserPassword/{p_id}', 'AdminController@updateUserPassword')->name('admin.updateUserPassword');
    Route::post('/admin/submitUpdateUserPassword', 'AdminController@submitUpdateUserPassword')->name('admin.submitUpdateUserPassword');
    //------------------------------------------------------------------------------------------------------------------


    //Article ----------------------------------------------------------------------------------------------------------
    Route::get('/admin/articles', 'AdminController@articles')->name('admin.articles');
    Route::get('/admin/articles_v', 'AdminController@articles_v')->name('admin.articles_v');
    Route::get('/admin/articles_nv', 'AdminController@articles_nv')->name('admin.articles_nv');

    Route::post('/admin/submitArticlesValide', 'AdminController@submitArticlesValide')->name('admin.submitArticlesValide');

    Route::get('/admin/article/{p_id}', 'AdminController@article_nv')->name('admin.article');

    Route::get('/admin/addArticle', 'AddController@addArticle')->name('admin.addArticle');
    Route::post('/admin/submitUpdateArticle', 'AdminController@submitUpdateArticle')->name('admin.submitUpdateArticle');
    //------------------------------------------------------------------------------------------------------------------

});


/***************************************
 * Vend routes protected by adminMiddleware
 ****************************************/
Route::group(['middleware' => 'vend'], function () {
    Route::get('/vend', 'VendeurController@home')->name('vend.home');
});

/***************************************
 * Direct routes protected by adminMiddleware
 ****************************************/
Route::group(['middleware' => 'direct'], function () {
    Route::get('/direct', 'DirectController@home')->name('direct.home');
});

/***************************************
 * Authentification
 ****************************************/
Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@submitLogin')->name('submitLogin');
Route::get('/logout', 'AuthController@logout')->name('logout');
/*********************************************************************************/


/**************************************
 * Routes Delete
 ***************************************/
Route::get('/direct/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('direct.delete');
Route::get('/magas/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('magas.delete');
/******************************************************************************/

/***************************************
 * Routes Excel:
 ****************************************/
Route::get('/export/{p_table}', 'ExcelController@export')->name('export');
/*********************************************************************************/


//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
