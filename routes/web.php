<?php

use App\Models\User;
use App\Models\Marque;
use App\Models\SentinelUser;
use App\Models\SentinelRole;


Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/s', function () {

    //dump(session()->all());
});

/***************************************
 * Magas routes protected by adminMiddleware
 ****************************************/
Route::group(['middleware' => 'magas'], function () {

    //Afficher la page d'accueil ==> Magas
    Route::get('/magas', 'MagasController@home')->name('magas.home');

    //Gestion des Articles: Lister
    Route::get('/magas/fournisseurs', 'MagasController@fournisseurs')->name('magas.fournisseurs');
    Route::get('/magas/agents', 'MagasController@agents')->name('magas.agents');
    Route::get('/magas/articles', 'MagasController@articles')->name('magas.articles');

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


    Route::get('/magas/addFournisseur', 'AddController@addFournisseur')->name('magas.addFournisseur');
    Route::get('/magas/addAgent', 'AddController@addAgent')->name('magas.addAgent');
    Route::get('/magas/addArticle', 'AddController@addArticle')->name('magas.addArticle');


    //Gestion des Magasins
    Route::get('/magas/magasins', 'MagasController@magasins')->name('magas.magasins');
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


/***************************************
 * Routes Excel:
 ****************************************/
Route::get('/export/{p_table}', 'ExcelController@export')->name('export');
/*********************************************************************************/


/**************************************
 * Routes AddForm et SubmitAdd
 ***************************************/
/*
Route::get('/admin/add/{p_table}', 'AddController@addForm')->name('admin.add');
Route::post('/admin/submitAdd/{p_table}', 'AddController@submitAdd')->name('admin.submitAdd');

Route::get('/direct/add/{p_table}', 'AddController@addForm')->name('direct.add');
Route::post('/direct/submitAdd/{p_table}', 'AddController@submitAdd')->name('direct.submitAdd');

Route::get('/magas/add/{p_table}', 'AddController@addForm')->name('magas.add');
Route::post('/magas/submitAdd/{p_table}', 'AddController@submitAdd')->name('magas.submitAdd');
/******************************************************************************/

/**************************************
 * Routes Update
 ***************************************/
Route::get('/admin/update/{p_table}/{p_id}', 'UpdateController@updateForm')->name('admin.update');
Route::post('/admin/submitUpdate/{p_table}', 'UpdateController@submitUpdate')->name('admin.submitUpdate');

Route::get('/direct/update/{p_table}/{p_id}', 'UpdateController@updateForm')->name('direct.update');
Route::post('/direct/submitUpdate/{p_table}', 'UpdateController@submitUpdate')->name('direct.submitUpdate');

Route::get('/magas/update/{p_table}/{p_id}', 'UpdateController@updateForm')->name('magas.update');
Route::post('/magas/submitUpdate/{p_table}', 'UpdateController@submitUpdate')->name('magas.submitUpdate');
/******************************************************************************/

/**************************************
 * Routes Delete
 ***************************************/

Route::get('/direct/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('direct.delete');
Route::get('/magas/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('magas.delete');
/******************************************************************************/

/*****************************************
 * Routes Lister et infos
 *****************************************/
Route::get('/direct/info/{p_table}/{p_id}', 'ShowController@info')->name('direct.info');
Route::get('/admin/info/{p_table}/{p_id}', 'ShowController@info')->name('admin.info');
Route::get('/magas/info/{p_table}/{p_id}', 'ShowController@info')->name('magas.info');

Route::get('/admin/lister/{p_table}', 'ShowController@lister')->name('admin.lister');
Route::get('/direct/lister/{p_table}', 'ShowController@lister')->name('direct.lister');
Route::get('/magas/lister/{p_table}', 'ShowController@lister')->name('magas.lister');
/*******************************************************************************/

/****************************************
 * Routes gestion des Stocks
 *****************************************/
Route::get('/direct/addStock/{p_id_magasin}', 'StockController@addStock')->name('direct.addStock');
Route::post('/direct/submitAddStock', 'StockController@submitAddStock')->name('direct.submitAddStock');

Route::get('/direct/supply/{p_id_magasin}', 'StockController@supplyStock')->name('direct.supplyStock');
Route::post('/direct/submitSupply', 'StockController@submitSupplyStock')->name('direct.submitSupplyStock');

//magasinier
Route::get('/magas/addStock/{p_id_magasin}', 'StockController@addStock')->name('magas.addStock');
Route::post('/magas/submitAddStock', 'StockController@submitAddStock')->name('magas.submitAddStock');

Route::get('/magas/supply/{p_id_magasin}', 'StockController@supplyStock')->name('magas.supplyStock');
Route::post('/magas/submitSupply', 'StockController@submitSupplyStock')->name('magas.submitSupplyStock');
/*******************************************************************************/


//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
