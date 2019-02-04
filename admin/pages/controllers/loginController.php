<?php

requestMap(['index', 'login', 'logout'], new LoginController);

class LoginController 
{
	public function index($request)
	{
		view('login');
	}

	public function login($request)
	{
		if($request->email != '' && $request->password != '')
		{
			$model = resolve('\\Models\\User');
			$user = $model->where([
				'email' => $request->email,
				'password' => $request->password // TODO: password needs to be hashed/protected
			])->first();
			if($user){
				session('id', $user->id);
				session('name', $user->name);
				session('email', $user->email);
				session('avatar', $user->avatar);
				session('role_id', $user->role_id);
				controller('dashboardController', 'index');
			}
		}
		session('error', 'Invalid username or password!');
		controller('loginController', 'index');
	}

	public function logout($request)
	{
		sessionFlush();
		controller('loginController', 'index');
	}

}