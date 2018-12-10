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

// seeders will fall here.
// 1. Let's create roles
$role = resolve('\\Models\\Role');
$role->create([
	'name' => 'Admin',
	'slug' => 'admin'
]);
$role->create([
	'name' => 'Developer',
	'slug' => 'dev'
]);
$role->create([
	'name' => 'Content Manager',
	'slug' => 'cm'
]);
// 2. Let's add some basic permissions
$permission = resolve('\\Models\\Permission');
$permission->create([
	'name' => 'Can Create Page',
	'slug' => 'can_create_page'
]);
$permission->create([
	'name' => 'Can Edit Page',
	'slug' => 'can_edit_page'
]);
$permission->create([
	'name' => 'Can Publish Page',
	'slug' => 'can_publish_page'
]);
$permission->create([
	'name' => 'Can Configure Plugins',
	'slug' => 'can_plugins'
]);
$permission->create([
	'name' => 'Can Configure Themes',
	'slug' => 'can_themes'
]);
$permission->create([
	'name' => 'Can Create User',
	'slug' => 'can_create_user'
]);
$permission->create([
	'name' => 'Can Edit User',
	'slug' => 'can_edit_user'
]);
$permission->create([
	'name' => 'Can Configure User Permissions',
	'slug' => 'can_user_permissions'
]);
// 3. Let's create admin user
$admin_role_id = $role->where('slug', 'admin')->first()->id;
$user = resolve('\\Models\\User');
$user->create([
	'name' => $_POST['name'],
	'email' => $_POST['email'],
	'password' => $_POST['password'],
	'remember_token' => '', // @farrukh please take required action here
	'avatar' => 'default',
	'role_id' => $admin_role_id, //admin
]);
// 4. Let's assign admin role with required all permissions
$role_permission = resolve('\\Models\\RolePermission');
$permissions = $permission->all();
foreach($permissions as $permission){
	$role_permission->create([
		'role_id' => $admin_role_id,
		'permission_id' => $permission->id
	]);
}

// redirect after settings & seeding
redirect('/index.php?page=install/step-three');