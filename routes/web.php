<?php

Route::group(['prefix' => 'panel', 'namespace' => 'Panel', 'middleware' => ['auth', 'checkifisadmin']], function() {
    Route::any('brands/search', 'BrandController@search')->name('brands.search');
    Route::get('brands/{id}/planes', 'BrandController@planes')->name('brands.planes');
    Route::resource('brands', 'BrandController');
    
    Route::any('planes/search', 'PlaneController@search')->name('planes.search');
    Route::resource('planes', 'PlaneController');

    Route::post('states/search', 'StateController@search')->name('states.search');
    Route::get('states', 'StateController@index')->name('states.index');

    Route::any('states/{initials}/cities/search', 'CityController@search')->name('state.cities.search');
    Route::get('states/{initials}/cities', 'CityController@index')->name('state.cities');

    Route::any('flights/search', 'FlightController@search')->name('flights.search');
    Route::resource('flights', 'FlightController');

    Route::any('city/{id}/airports/search', 'AirportController@search')->name('airports.search');
    Route::resource('city/{id}/airports', 'AirportController');

    Route::any('users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');

    Route::any('reserves/search', 'ReserveController@search')->name('reserves.search');
    Route::resource('reserves', 'ReserveController', [
        'except' => ['show', 'destroy']
    ]);

    Route::get('/', 'PanelController@index')->name('panel');
});

Route::get('promocoes', 'Site\SiteController@promotions')->name('promotions');

Route::group(['middleware' => 'auth'], function() {
    Route::get('meu-perfil', 'Panel\UserController@myProfile')->name('my.profile');
    Route::post('atualizar-perfil', 'Panel\UserController@updateProfile')->name('update.profile');
    Route::get('sair', 'Panel\UserController@logoutProfile')->name('logoutProfile');

    Route::get('detalhes-compra/{idReserve}', 'Site\SiteController@purchaseDetail')->name('purchase.detail');
    Route::get('minhas-compras', 'Site\SiteController@myPurchases')->name('my.purchases');
    Route::get('detalhes-voo/{id}', 'Site\SiteController@detailsFlight')->name('details.flight');
    Route::post('reservar', 'Site\SiteController@reserveFlight')->name('reserve.flight');
});

Route::post('pesquisar', 'Site\SiteController@search')->name('search.flights.site');
Route::get('/', 'Site\SiteController@index')->name('home');
Auth::routes();
