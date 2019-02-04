<?php

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
		//redirect('/?target=admin&page=dashboard');
		view('dashboard');
	}

}