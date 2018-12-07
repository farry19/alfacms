<?php

// Save basic web application information into options

// @farrukh can you please make some proper "request" class
// which can take care of POST, GET, etc requests

$option = resolve('\\Models\\Option');

$option->create([ // @farrukh, will be good if we have createOrUpdate method as well?
	'name' => 'app_name',
	'value' => $_POST['app_name'] 
]);
$option->create([
	'name' => 'app_type',
	'value' => $_POST['app_type'] 
]);
$option->create([
	'name' => 'app_url',
	'value' => $_POST['app_url'] 
]);
$option->create([
	'name' => 'app_theme',
	'value' => $_POST['app_theme'] 
]);

// seeder will fall here.



// redirect after settings & seeding
redirect('/index.php?page=install/step-three');