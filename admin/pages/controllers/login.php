<?php

// TODO: overall controller logic needs to be improved

if(isset($_POST['email']) && isset($_POST['password'])){
	// TODO: these should be a CSRF token logic to prevent crawler & other bot attacks
	$email = $_POST['email'];
	$password = $_POST['password'];

	if($email != '' && $password != ''){
		$model = resolve('\\Models\\User');
		$user = $model->where([
			'email' => $email,
			'password' => $password // TODO: password needs to be hashed/protected
		])->first();
		if($user){
			// TODO: we need to implement sessions logic to store logged in user
			redirect('/?target=admin&page=dashboard');
		}
	}
	// TODO: need to implement flash sessions to store error message for view
	redirect('/?target=admin&page=login');
}