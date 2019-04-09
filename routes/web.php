<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

	//working well in localhost but on the remote server it reports the access denied error. I created this policy after deploying the site on the server so I create a route /clear-cache with code

    // Route::get('/clear-cache', function() {
    //     $exitCode = \Illuminate\Support\Facades\Artisan::call('cache:clear');
    // });
	Route::get('/', 'HomeController@index')->name('home.index');
	
    Auth::routes(['verify' => 'true']);//?????
	Route::get('/verify/{token}', 'OrdersAllsController@verify');
	Route::get('/verifySecond/{token}', 'OrdersAllsController@verifySecond');

    //Route::get('books/{book}', 'Admin\BooksController@show');   
    //Route::get('magazins/{id}', 'Admin\MagazinsController@show');
	Route::group(['middleware'	=>	'auth'], function(){
		Route::get('/verification', ' VerificationController@resend')->name('verification.resend');
		Route::resource('/purchases', 'PurchasesController');////// /order mistake on views + no p.create
		Route::group(['prefix' => 'purchases'], function(){
			Route::get('/toggleBeforeToggle/{id}', 'PurchasesController@toggleBeforeToggle');
		});
		//old
		// Route::get('/order', 'PurchasesController@index')->name('purchases.index');//!!!!!!/orderlink
		// Route::post('/purchase', 'PurchasesController@store');
		// Route::get('/purchase/{id}', 'PurchasesController@show')->name('purchases.show');
		 //Route::get('/purchase/{id}', 'PurchasesController@edit')->name('purchases.edit');//do I use it?
		 //Route::put('/purchase/{id}/update', 'PurchasesController@update')->name('purchases.update');//?
		// Route::delete('/purchases/{id}/destroy', 'PurchasesController@destroy')->name('purchases.destroy');	//////////resource end
		Route::get('/cart', 'PurchasesController@indexCart')->name('cart');
		Route::get('/purchasebuy', 'PurchasesController@buy')->name('purchases.buy');
		Route::get('/sendemail/{id}', 'PurchasesController@resendEmail')->name('purchases.buyAlls');
		Route::delete('/purchasesAll/destroy', 'PurchasesController@destroyAll')->name('purchases.destroyAll');//args

		Route::group(['prefix'=>'purchases'], function(){
			Route::get('/toggleSubPrice/{id}', 'PurchasesController@toggleSubPrice');
			Route::resource('/ordersAlls', 'OrdersAllsController', ['only' => ['index', 'show',]]);//mistake on view  ordersAll.index, ordersAll.show
			Route::resource('/orders', 'OrdersController', ['only' => ['index', 'show',]]);
			//OrdersAllsController
			// Route::get('/ordersall', 'OrdersAllsController@index')->name('ordersAll.index');//tag route
			// Route::get('/ordersall/{id}', 'OrdersAllsController@show')->name('ordersAll.show');
			//OrdersController
			// Route::get('/orders', 'OrdersController@index')->name('orders.index');
			Route::get('/ordersextra', 'OrdersController@indexOrders')->name('orders.indexOrders');
			Route::post('order/{order}/{ordersAll}', 'OrdersController@addOrdersAll');
		});
		//UsersController
		Route::get('/profile', 'ProfileController@index');
		Route::post('/profile', 'ProfileController@store');
		Route::get('/logout', 'AuthController@logout');
	});

	Route::group(['middleware'	=>	'guest'], function(){
		//UsersController
	 	Route::get('/register', 'AuthController@registerForm');
	 	Route::post('/register', 'AuthController@register');
	 	Route::get('/login','AuthController@loginForm')->name('login');
	 	Route::post('/login', 'AuthController@login');
	});

	Route::group(['prefix'=>'admin','namespace'=>'Admin', 'middleware'	=>	'admin'], function(){
	 	//Admin\UsersController	 	
		Route::get('/verification', ' VerificationController@resend');//->name('verification.resend');
	 	Route::get('/', 'DashboardController@index');
		Route::resource('/users', 'UsersController');
		Route::group(['prefix' => 'users'], function(){			
			Route::get('/toggleAdmin/{id}', 'UsersController@toggleAdmin');
			Route::get('/toggleBan/{id}', 'UsersController@toggleBan');
			Route::get('/toggleDiscontId/{id}', 'UsersController@toggleDiscontId');
			Route::get('/toggleVisibleIdAll', 'UsersController@toggleVisibleIdAll')->name('admin.users.toggleVisibleIdAll');
		});
		//Admin\BooksController
		//Route::whenRegex('/^admin(\/(?/book)\S+)?S/','Restricted:admin');
		Route::resource('/books', 'BooksController');
		// Route::get('books', 'BooksController@index')->name('admin.books.index');
		// Route::get('books', 'BooksController@create')->name('books.create');
	 //    Route::post('books', 'BooksController@store')->name('books.store');
	 //    Route::delete('books/{book}', 'BooksController@destroy')->name('books.destroy');
	 //    Route::get('books', 'BooksController@edit')->name('books.edit');
	 //    Route::put('books/{book}', 'BooksController@update')->name('books.update');
		Route::group(['prefix' => 'books'], function(){
			Route::get('/toggleDiscontGlB/{id}', 'BooksController@toggleDiscontGlB');
			Route::get('/toggleVisibleGlBAll', 'BooksController@toggleVisibleGlBAll')->name('admin.books.toggleVisibleGlBAll');
			Route::get('/toggleHard/{id}', 'BooksController@toggleHard');//->name('admin.books.toggleHard');
		});
		
		//Admin\MagazinsController
		//Route::whenRegex('/^admin(\/(?/magazin)\S+)?S/','Restricted:admin');
		Route::resource('/magazins', 'MagazinsController');
		// Route::get('magasins', 'MagazinsController@index')->name('admin.magazins.index');
		// Route::get('magasins', 'MagazinsController@create')->name('magazins.create');
	 //    Route::post('magasins', 'MagazinsController@store');
	 //    Route::delete('magasins/{id}', 'MagazinsController@destroy');
	 //    Route::get('magasins', 'MagazinsController@edit')->name('magazins.edit');
	 //    Route::put('magasins/{id}', 'MagazinsController@update')->name('magazins.update');
		Route::group(['prefix' => 'magazins'], function(){

			Route::get('/toggleDiscontGlM/{id}', 'MagazinsController@toggleDiscontGlM');
			Route::get('/toggleVisibleGlMAll', 'MagazinsController@toggleVisibleGlMAll')->name('admin.magazins.toggleVisibleGlMAlll');
		});
		//Admin\PurchasesController
		// Route::get('/purchases', 'PurchasesController@index')->name('admin.purchases.index');		
		Route::resource('/purchases','PurchasesController', ['only' => ['index',]]);//?all admin policy
		Route::group(['prefix' => 'purchases'], function(){
			Route::get('/purchasesdaybefore', 'PurchasesController@indexDayBefore')->name('admin.purchases.indexDayBefore');
			Route::get('/purchasesweekbefore', 'PurchasesController@indexWeekBefore')->name('admin.purchases.indexWeekBefore');
			Route::get('/purchasesmonthbefore', 'PurchasesController@indexMonthBefore')->name('admin.purchases.indexMonthBefore');
		});

	 });

	// Route::get('book/{book_id}/{publisher_id}', 'BookController@setPublisher');//??????????
 //    Route::get('book', 'BookController@index');
 //    Route::get('book/{book}', 'BookController@show');
 //    Route::post('book', 'BookController@store');
 //    Route::delete('book/{book}', 'BookController@destroy');
 //    Route::put('book/{book}', 'BookController@update');

	