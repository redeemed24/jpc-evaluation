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


Route::get('/','UsersController@evaluationLogin');

Route::post('evaluate','UsersController@startEvaluation');
Route::get('evaluate','UsersController@evaluate');

Route::post('login', 'UsersController@postLogin');
Route::post('calculate', 'ResultsController@calculateEvaluation');

Route::get('admin', function()
{
	if (Auth::check()) {
		return redirect('home');
	}else{
		return view('login');
	}
});

Route::group(['middleware' => ['auth'] ], function(){

	Route::get('logout','UsersController@getLogout');
	
	Route::resource('results', 'ResultsController');
	Route::match(['get', 'post'],'import', 'EvaluationsController@import');
	Route::post('mail', 'UsersController@mail');
	Route::resource('teachers', 'TeachersController');

	Route::group(['middleware' => ['auth', 'admin']], function() {
		Route::get('settings/edit', 'UsersController@settings');
		Route::post('settings/save', 'UsersController@saveDashboardConfig');

		Route::get('home','UsersController@home');
		Route::resource('evaluation', 'EvaluationsController');
		Route::resource('questions', 'QuestionsController');
		Route::resource('subjects', 'SubjectsController');
		Route::resource('departments', 'DepartmentsController');
		Route::resource('question_categories', 'QuestionCategoriesController');
		Route::resource('users', 'UsersController');
		Route::resource('evaluations', 'EvaluationsController');
	});

});

Route::get('createAccount', 'UsersController@createAccount');

// If route doesn't exist
Route::any( '{catchall}', function ( $page ) {
    return "<h1>Error 404: Page not found</h1>";
    // return redirect('error');
} )->where('catchall', '(.*)');
