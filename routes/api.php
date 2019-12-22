<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
Route::group(['middleware' => 'auth:api'], function(){

    Route::post('getUser', 'Api\AuthController@getUser');
    Route::get('logout', 'Api\AuthController@logout');

    Route::resource('category', 'API\CategoryController');
    Route::post('category/{id}','API\CategoryController@update');
    Route::get('category/{id}/getsubcategories','API\CategoryController@showSubcategories');
    Route::get('category/{id}/getproducts','API\CategoryController@getProductsBycategoryID');

    Route::resource('category/{id}/subcategory', 'API\SubcategoryController');
    Route::post('category/{id}/subcategory/{id1}','API\SubcategoryController@update');
    Route::get('getcategory/{id}/subcategory/{id1}','API\SubcategoryController@getCategory');
    Route::get('subcategory/{id}/getproducts','API\SubcategoryController@getProductsBysubcategoryID');

    Route::post('{id}/addproduct','API\ProductController@store');
    Route::post('updateproduct/{id}','API\ProductController@update');
    Route::resource('products','API\ProductController');

    Route::post('paniers/{iduser}/{idproduct}','API\PanierController@store');
    Route::get('paniers/{id}/products','API\PanierController@getAllproductsOfPanierAndTotal');
    Route::post('paniers/{id}/Removeproduct/{idproduct}','API\PanierController@deleteProductByIdfromPanier');
    Route::resource('paniers','API\PanierController');

    Route::post('panier/{idpanier}/order','API\CommandeController@store');
    Route::resource('order','API\CommandeController');
    Route::get('order/{id}/getproducts','API\CommandeController@getProductsOfOrder');
    Route::get('user/{iduser}/getorders','API\CommandeController@getAlluserOrders');

    Route::post('wishlist/{idwishlist}/{idproduct}','API\WishlistController@store');
    Route::resource('wishlist','API\WishlistController');
    Route::post('wishlist/{id}/Removeproduct/{idproduct}','API\WishlistController@deleteProductByIdfromwishlist');

    Route::get('hotdeals/{Number}','API\ProductController@getHotdeals');
    Route::get('topselling/{Number}','API\ProductController@getTopsellings');

    Route::post('searchproduct','API\ProductController@SearchProduct');
});
