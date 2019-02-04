<?php

namespace Admin\Controllers;

use Models\Page;

requestMap(['index'], new Controller);

class Controller 
{
	public function index($request)
	{
		if(!sessionHas('id'))
		{
			session('error', 'Session expired!');
			controller('loginController', 'logout');
		}

		$pages = Page::all();
		
		view('pages/index', [
			'pages' => $pages
		]);
	}

}