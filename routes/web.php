<?php



Route::get('/', function () {
    return view('welcome');
});

Route::get('/s', function () {
    dump(Sentinel::check());
    dump(Session::all());
    dump(request());
    dump(session());
    //dump(session());
});


Route::get('/a', function () {
    return "admin";
})->middleware('admin');

Route::get('/m', function () {
    return "magas";
})->middleware('magas');

Route::get('/v', function () {
    return "vend";
})->middleware('vend');

Route::get('/d', function () {
    return "direct";
})->middleware('direct');


Route::group(['middleware' => 'admin'], function () {

    Route::get('/admin', 'AdminController@home')->name('admin.home');

    Route::get('/admin/add/{p_table}', 'AddController@addForm')->name('admin.add')->middleware('admin');
    Route::post('/admin/submitAdd/{p_table}', 'AddController@submitAdd')->name('admin.submitAdd');

});

Route::group(['middleware' => 'magas'], function () {

    Route::get('/magas', 'MagasController@home')->name('magas.home');
});

Route::group(['middleware' => 'vend'], function () {

    Route::get('/vend', 'VendeurController@home')->name('vend.home');
});

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
Route::get('/admin/delete/{p_table}/{p_id}', 'DeleteController@delete')->name('admin.delete');
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

Route::get('/home', 'HomeController@index')->name('home');