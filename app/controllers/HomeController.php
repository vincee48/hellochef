<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function home()
	{
		return View::make('index');
	}

	public function about()
	{
		return View::make('info.about');
	}

	public function browse()
	{
		return View::make('info.browse');
	}

	public function faq()
	{
		return View::make('info.faq');
	}

	public function gallery()
	{
		return View::make('info.gallery');
	}

	// Legal pages
	public function terms()
	{
		return View::make('legal.terms');
	}

	public function privacy()
	{
		return View::make('legal.privacy');
	}

}
