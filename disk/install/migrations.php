<?php

migrate('options', function($table) {
	$table->increments('id');
	$table->string('name');
	$table->string('value');

	$table->timestamps();
});

migrate('pages', function($table) {
    $table->increments('id');    
    $table->string('title');
    $table->string('slug');
    $table->text('body');
    $table->text('script');
    $table->text('css');
    $table->enum('status', ['draft', 'unpublished', 'published'])->default('draft');

    $table->timestamps();
});

migrate('menus', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('slug');
    $table->unsignedInteger('menu_id')->default(-1);
    $table->unsignedInteger('page_id')->nullable();

    $table->timestamps();
});

migrate('users', function($table) {
    $table->increments('id');
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email');
    $table->string('password');
    $table->string('remember_token');
    $table->string('avatar');
    $table->unsignedInteger('role_id');

    $table->timestamps();
});

migrate('themes', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('slug');
    $table->string('path');
    $table->enum('status', ['active', 'inactive', 'outdated'])->default('inactive');

    $table->timestamps();
});

migrate('roles', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('slug');

    $table->timestamps();
});

migrate('permissions', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('slug');

    $table->timestamps();
});

migrate('role_permissions', function($table) {
    $table->increments('id');
    $table->unsignedInteger('role_id');
    $table->unsignedInteger('permission_id');

    $table->timestamps();
});

redirect('/index.php?page=install/step-two');