<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|------------------------------c--------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
 * START LANDING PAGE ROUTES
 * */
Route::get('/create', array('uses' => 'CreateController@index'));
Route::get('/', array('uses' => 'CreateController@index'));

Route::get('/productdetails/products/{product_id?}', array('uses' => 'CreateController@showdetails'));


Route::group(['prefix' => '/editlayouts/products/{product_id?}/'], function () {
    Route::get('panels/{panel_id?}', 'WelcomeController@editpanel');
    Route::get('designs/{design_id?}', 'WelcomeController@editdesign');
    Route::get('admindesigns/{adminDesign_id?}', 'WelcomeController@editadmindesign');
});

Route::get('designlayouts/{design_id?}', array('uses' => 'WelcomeController@designlayouts'));
Route::get('admindesignlayouts/{design_id?}', array('uses' => 'WelcomeController@admindesignlayouts'));

Route::post('/uploaduserimages' , 'WelcomeController@uploaduserimages');
Route::put('/saveuserimages' , 'WelcomeController@saveuserimages');
Route::get('/getuserimages/{user_id?}' , 'WelcomeController@getuserimages');
Route::delete('/deleteuserimage/{user_image_id?}','WelcomeController@destroyuserimage');

Route::group(['prefix' => 'learn'], function () {
    Route::get('/', array('uses' => 'Landing\VideosController@index'));
    Route::get('/videos/{videoId}', array('uses' => 'Landing\VideosController@show'));
    Route::get('/search', array('uses' => 'Landing\VideosController@search'));
    Route::post('/vote', array('uses' => 'Landing\VideosController@rate'));
    Route::post('/viewVideo', array('uses' => 'Landing\VideosController@viewVideo'));
});
Route::group(['prefix' => 'gallery'], function () {
    Route::get('/', array('uses' => 'Landing\GalleryController@index'));
    Route::post('comment','Landing\GalleryController@comment');
    Route::post('like','Landing\GalleryController@like');
});

Route::group(['prefix' => 'discover'], function () {
    Route::get('/', array('uses' => 'Landing\DiscoverController@index'));
    Route::get('/{productId}', array('uses' => 'Landing\DiscoverController@show'));

});


Route::group(['prefix' => 'me'], function () {

    Route::get('/profile', 'Landing\UserController@profile');
    Route::post('/profile', 'Landing\UserController@profileConfig');
    Route::get('/paymentConf',  'Landing\UserController@paymentConf');
    Route::post('/creditcard',  'Landing\UserController@creditCard');
    Route::post('/shippingaddress',  'Landing\UserController@shippingAddress');

});



/*
 * ENDING LANDING PAGE ROUTES
 * */

/*
 * START ADMIN  ROUTES
 * */

Route::group(['prefix' => 'adminCMS','middleware'=>['auth','isAdmin']], function () {

    Route::get('searchvideo', function()
    {
        return View::make('adminCMS/searchvideo');
    });

    Route::get('addproducts', function()
    {
        return View::make('adminCMS.addproducts');
    });
    Route::get('admineditor/products/{product_id?}/admindesigns/{adminDesign_id?}', array('uses' => 'AdmineditorController@editdesign'));
    Route::get('admineditor/products/{product_id?}', array('uses' => 'AdmineditorController@createdesign'));

    Route::get('designlayouts/{design_id?}', array('uses' => 'AdmineditorController@designlayouts'));

    Route::get('logout', array('uses' => 'HomeController@doLogout'));

    Route::get('home', array('uses' => 'HomeController@index'));

    Route::get('productlayouts', array('uses' => 'ProductLayoutsController@index'));
    Route::get('editdesigns/products/{product_id?}','ProductLayoutsController@editdesigns');
    Route::get('editlayouts','ProductLayoutsController@editlayouts');

    Route::get('pictures', 'PictureListController@index');
    Route::get('lines', 'LineListController@index');
    Route::get('grids', 'GridListController@index');
    Route::get('frames', 'FrameListController@index');
    Route::get('illustrations', 'IllustrationListController@index');
    Route::get('backgrounds', 'BackgroundListController@index');

    Route::get('layouts/{layout_id?}', 'AdminLayoutsController@show');
    Route::get('getlayouts', 'AdminLayoutsController@getlayouts');
    Route::get('getlayoutsrc', 'AdminLayoutsController@getlayoutsrc');
    
    Route::post('layouts', 'AdminLayoutsController@store');
    Route::post('createdesign', 'AdminLayoutsController@createdesign');    

    Route::put('savecropimage', 'AdminLayoutsController@savecropimage');
    Route::put('layouts/{layout_id?}','AdminLayoutsController@update');
    Route::put('savelayouts/{layout_id?}','AdminLayoutsController@uploadAdminlayout');
    Route::delete('editlayouts/{layout_id?}','AdminLayoutsController@destroylayout');
    Route::delete('editdesigns/{design_id?}','AdminLayoutsController@destroydesign');

    Route::get('fonts' , 'FontsController@index');
    Route::get('fonts/{font_id?}', 'FontsController@show');
    Route::get('searchfonts/{search_input?}', 'FontsController@search');
    Route::post('fontcreate', 'FontsController@create');
    Route::put('fonts/{font_id?}','FontsController@update');
    Route::delete('fonts/{font_id?}','FontsController@destroy');

    Route::get('backgrounds' , 'BackgroundsController@index');
    Route::get('backgrounds/{background_id?}', 'BackgroundsController@show');
    Route::get('searchbackgrounds/{search_input?}', 'BackgroundsController@search');
    Route::post('backgroundcreate', 'BackgroundsController@create');
    Route::put('backgrounds/{background_id?}','BackgroundsController@update');
    Route::delete('backgrounds/{background_id?}','BackgroundsController@destroy');
    Route::get('editbackgrounds/{background_id?}','BackgroundsController@edit');

    Route::get('pictures' , 'PicturesController@index');
    Route::get('pictures/{picture_id?}', 'PicturesController@show');
    Route::get('searchpictures/{search_input?}', 'PicturesController@search');
    Route::post('picturecreate', 'PicturesController@create');
    Route::put('pictures/{picture_id?}','PicturesController@update');
    Route::delete('pictures/{picture_id?}','PicturesController@destroy');
    Route::get('editpictures/{picture_id?}','PicturesController@edit');

    Route::get('lines' , 'LinesController@index');
    Route::get('lines/{line_id?}', 'LinesController@show');
    Route::get('searchlines/{search_input?}', 'LinesController@search');
    Route::post('linecreate', 'LinesController@create');
    Route::put('lines/{line_id?}','LinesController@update');
    Route::delete('lines/{line_id?}','LinesController@destroy');
    Route::get('editlines/{line_id?}','LinesController@edit');

    Route::get('illustrations' , 'IllustrationsController@index');
    Route::get('illustrations/{illustration_id?}', 'IllustrationsController@show');
    Route::get('searchillustrations/{search_input?}', 'IllustrationsController@search');
    Route::post('illustrationcreate', 'IllustrationsController@create');
    Route::put('illustrations/{illustration_id?}','IllustrationsController@update');
    Route::delete('illustrations/{illustration_id?}','IllustrationsController@destroy');
    Route::get('editillustrations/{illustration_id?}','IllustrationsController@edit');

    Route::get('grids' , 'GridsController@index');
    Route::get('grids/{grid_id?}', 'GridsController@show');
    Route::get('searchgrids/{search_input?}', 'GridsController@search');
    Route::post('gridcreate', 'GridsController@create');
    Route::put('grids/{grid_id?}','GridsController@update');
    Route::delete('grids/{grid_id?}','GridsController@destroy');
    Route::get('editgrids/{grid_id?}','GridsController@edit');


    Route::get('frames' , 'FramesController@index');
    Route::get('frames/{frame_id?}', 'FramesController@show');
    Route::get('searchframes/{search_input?}', 'FramesController@search');
    Route::post('framecreate', 'FramesController@create');
    Route::put('frames/{frame_id?}','FramesController@update');
    Route::delete('frames/{frame_id?}','FramesController@destroy');
    Route::get('editframes/{frame_id?}','FramesController@edit');


    Route::get('products' , 'ProductsController@index');
    Route::get('product/{product_id?}', 'ProductsController@show');
    Route::get('searchproducts/{search_input?}', 'ProductsController@search');
    Route::post('addproducts', 'ProductsController@create');
    Route::post('updateproducts', 'ProductsController@updateproduct');
    Route::get('editproducts/{product_id?}','ProductsController@edit');
    Route::put('products/{product_id?}','ProductsController@update');
    Route::delete('products/{product_id?}','ProductsController@destroy');
    Route::post('products/removeFeature','ProductsController@removeFeature');

    Route::post('updateElement','adminCMS\ElementsController@elementDetails');

});

    Route::get('/layouts/{layout_id?}', 'LayoutsController@show');
    Route::get('/getlayouts', 'LayoutsController@getlayouts');
    Route::get('/getlayoutsrc', 'LayoutsController@getlayoutsrc');
    
    Route::post('/layouts', 'LayoutsController@store');
    Route::post('/createdesign', 'LayoutsController@createdesign');    

    Route::put('/savecropimage', 'LayoutsController@savecropimage');
    Route::put('/layouts/{layout_id?}','LayoutsController@update');
    Route::put('/savelayouts/{layout_id?}','LayoutsController@uploadlayout');
    Route::delete('/layouts/{layout_id?}','LayoutsController@destroy');



    Route::get('/searchbackgrounds/{keyword?}','BackgroundsController@searchbackgrounds');
    Route::get('/searchpictures/{keyword?}','PicturesController@searchpictures');
    Route::get('/searchlines/{keyword?}','LinesController@searchlines');
    Route::get('/searchillustrations/{keyword?}','IllustrationsController@searchillustrations');
    Route::get('/searchgrids/{keyword?}','GridsController@searchgrids');
    Route::get('/searchframes/{keyword?}','FramesController@searchframes');
    Route::get('/searchproducts/{keyword?}','ProductsController@searchpictures');

    Route::get('searchElements','Landing\ElementsController@searchElements');

    Route::resource('orders','OrdersController');
    Route::get('elementPurchased','OrdersController@elementPurchased');
    Route::post('publish/spiff','PublishController@spiff');


    Route::group(['prefix' => 'adminCMS','middleware'=>['auth','isAdmin']], function () {
        Route::get('videos/category/{categoryId?}', 'AdminCMS\VideosController@index');
        Route::resource('videos', 'AdminCMS\VideosController');
        Route::resource('categories', 'AdminCMS\CategoryController');
        Route::resource('users','AdminCMS\UsersController');

        Route::get('gallery', array('uses' => 'AdminCMS\GalleryController@index'));
        Route::post('gallery', array('uses' => 'AdminCMS\GalleryController@statusGallery'));
        Route::post('searchElements','AdminCMS\ElementsController@searchElements');
    });

    Route::group(['prefix' => 'targets'], function () {
        Route::post('evaluate', 'VuforiaController@evaluate');
        Route::post('store','TargetsController@store');
        Route::post('video','TargetsController@updateVideo');
        Route::post('imageRemove','TargetsController@imageRemove');
        Route::post('images','TargetsController@images');
    });

    Auth::routes();

    Route::get('/home', 'HomeController@index');

    Route::get('test',function(){

    });