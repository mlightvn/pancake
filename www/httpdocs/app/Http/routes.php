<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('', 'UserController@index');
Route::get('home', 'UserController@index');

Route::get('api/autodeploy', 'ApiController@autodeploy');


Route::group(['prefix' => 'admin'], function()
{
	Route::auth();

	Route::group(['prefix' => 'scraping'], function()
	{
		Route::get('', 'ScrapingController@index');
		Route::get('index', 'ScrapingController@index');
	});

	Route::get('login', 'AdminController@getLogin');
	Route::post('login', 'AdminController@authenticate');

	Route::any('logout', 'AdminController@getLogout');

	Route::get('', [
		'middleware' => 'admin',
		'uses' => 'AdminController@index'
	]);
	Route::get('index', [
		'middleware' => 'admin',
		'uses' => 'AdminController@index'
	]);
	Route::get('home', [
		'middleware' => 'admin',
		'uses' => 'AdminController@index'
	]);

	Route::group(['prefix' => 'company'], function()
	{
		Route::match(['get', 'post'], '', 'AdminCompanyController@listData');
		Route::match(['get', 'post'], 'list', 'AdminCompanyController@listData');

		Route::match(['get', 'post'], 'add', 'AdminCompanyController@add');
		Route::match(['get', 'post'], '{id?}/edit', 'AdminCompanyController@edit');

		Route::match(['get', 'post'], '{id?}/image/edit', 'AdminCompanyController@imageedit');

		Route::get('{company_id}/image/delete/{image_name}', 'AdminCompanyController@imagedelete'); //Delete image

		Route::get('downloadCsv', 'AdminCompanyController@downloadCsv');
	});

	//Product
	Route::group(['prefix' => 'product'], function()
	{
		Route::match(['get', 'post'], '', 'AdminProductController@listData');
		Route::match(['get', 'post'], 'list', 'AdminProductController@listData');
		Route::match(['get', 'post'], '?company_id={company_id}', 'AdminProductController@listData');
		Route::match(['get', 'post'], 'list?company_id={company_id}', 'AdminProductController@listData');

		Route::match(['get', 'post'], 'add', 'AdminProductController@add'); //Add page
		Route::match(['get', 'post'], '{id}/edit', 'AdminProductController@edit'); //Edit page
		Route::match(['get', 'post'], '{id}/image/edit', 'AdminProductController@imageedit'); //Edit page

		Route::get('{id}/image/delete/{image_name}', 'AdminProductController@imagedelete'); //Delete image

		Route::get('downloadCsv', 'AdminProductController@downloadCsv');
	});

	//Category
	Route::group(['prefix' => 'category'], function()
	{
		Route::get('', 'AdminCategoryController@listData');
		Route::get('list', 'AdminCategoryController@listData');

		Route::match(['get', 'post'], 'add', 'AdminCategoryController@add'); //Add page

		Route::match(['get', 'post'], '{id}/edit', 'AdminCategoryController@edit'); //Edit page
	});

	// ビデオ
	Route::group(['prefix' => 'video'], function()
	{
		Route::get('', 'AdminVideoController@listData');
		Route::get('list', 'AdminVideoController@listData');

		Route::match(['get', 'post'], 'add', 'AdminVideoController@add'); //Add page

		Route::match(['get', 'post'], '{id}/edit', 'AdminVideoController@edit'); //Edit page
	});

	//Member
	Route::group(['prefix' => 'member'], function()
	{
		Route::match(['get', 'post'], '', 'AdminMemberController@listData');
		Route::match(['get', 'post'], 'list', 'AdminMemberController@listData');

		Route::match(['get', 'post'], '{id}/edit', 'AdminMemberController@edit'); //Edit page

		Route::match(['get', 'post'], '{id}/image/edit', 'AdminMemberController@imageedit'); //Edit page
		Route::get('{id}/image/delete/{image_name}', 'AdminMemberController@imagedelete'); //Delete image

		Route::get('downloadCsv', 'AdminMemberController@downloadCsv');
	});

});


Route::group(['prefix' => 'game'], function()
{
	Route::get('', 'GameController@index');

	Route::group(['prefix' => 'panda'], function()
	{
		Route::get('', function () {
			return view('game.panda.index');
		});
		Route::get('index', function () {
			return view('game.panda.index');
		});

		Route::get('dev', function () {
			return view('game.panda.dev');
		});

	});
});


Route::group(['prefix' => 'company'], function()
{
	Route::get('', 'CompanyController@index');
	Route::get('login', 'CompanyController@login');

	Route::get('edit', 'CompanyController@companyedit'); //Edit page
	Route::post('edit', 'CompanyController@companyedit'); //Update into DB

	Route::get('image/edit', 'CompanyController@companyimageedit'); //Edit image
	Route::post('image/edit', 'CompanyController@companyimageedit'); //Upload & Update into DB

	Route::get('image/delete', 'CompanyController@companyimagedelete'); //Delete image

	//Product
	Route::group(['prefix' => 'product'], function()
	{
		Route::get('', 'CompanyController@productlist');
		Route::get('list', 'CompanyController@productlist');

		Route::get('add', 'CompanyController@productadd'); //Add page
		Route::post('add', 'CompanyController@productadd'); //Insert into DB

		Route::get('{product_id}/edit', 'CompanyController@productedit'); //Edit page
		Route::post('{product_id}/edit', 'CompanyController@productedit'); //Update into DB

		Route::get('{product_id}/image/edit', 'CompanyController@productimageedit'); //Edit page
		Route::post('{product_id}/image/edit', 'CompanyController@productimageedit'); //Update into DB

		Route::get('{product_id}/image/delete/{image_name}', 'CompanyController@productimagedelete'); //Delete image
	});

});


Route::get('search', 'UserController@search');
Route::get('category/{slug}', 'UserController@searchCategory');
Route::get('tu-khoa/{keyword}', 'UserController@searchByKeyword');


// Route::resource('member', 'MemberController');

Route::get('/member/login/redirect', 'FacebookController@redirect');
Route::get('/member/login/callback', 'FacebookController@callback');

Route::group(['prefix' => 'member'], function()
{
	Route::get('', 'MemberController@index');
	Route::get('index', 'MemberController@index');

	Route::any('login', 'MemberController@login');
	Route::any('signup', 'MemberController@signup');
	Route::any('logout', 'MemberController@getLogout');

	Route::get('edit', 'MemberController@edit');
	Route::post('edit', 'MemberController@store'); //update

	Route::any('leave', 'MemberController@leave');
});

//Product
Route::group(['prefix' => 'san-pham'], function()
{
	Route::any('{id}', 'ProductController@index');
});


Route::group(['prefix' => 'doi-tac'], function()
{
	Route::get('', 'SiteController@index');
	Route::get('index', 'SiteController@index');

	Route::get('{slug}', 'SiteController@searchCompany');
	Route::get('{slug}/san-pham', 'UserController@searchCompanyProduct');
});



Route::get('chinh-sach', function()
{
	return view('terms');
});

Route::get('lien-lac', 'ContactController@index');

Route::resource('lien-lac', 'ContactController', ['except' => ['create', 'show', 'edit', 'update', 'destroy']]);
Route::get('lien-lac-hoan-tat', function()
{
	return view('contact_finish');
});

// =================================================================
// =================================================================
// =================================================================

Route::group(['prefix' => 'wiki'], function()
{
	Route::get('', function()
	{
		return view('wiki.index');
	});

});

Route::group(['prefix' => 'game'], function()
{
	Route::get('flappy_rect', function()
	{
		return view('game.flappy_rect');
	});

	Route::get('bomber', function()
	{
		return view('game.bomber');
	});

});

Route::group(['prefix' => 'tool'], function()
{
	Route::get('password_generate', function()
	{
		return view('tool.password_generate');
	});

	Route::get('pdf', 'ToolController@pdf_get');
	Route::post('pdf', 'ToolController@pdf_post');

});
