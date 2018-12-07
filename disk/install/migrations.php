<?php

migrate('options', function($table) {
	$table->increments('id');
	$table->string('name');
	$table->string('value');

	$table->timestamps();
});

migrate('items', function($table) {
    $table->increments('id');
    $table->string('title');
    $table->text('body');
    $table->unsignedInteger('image_id')->nullable();
    $table->unsignedInteger('category_id')->nullable();
    $table->unsignedInteger('user_id');
    $table->enum('status', ['draft', 'unpublished', 'published'])->default('draft');

    $table->timestamps();
});

migrate('categories', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('description');
    $table->unsignedInteger('user_id');

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

migrate('roles', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('description');

    $table->timestamps();
});

migrate('permissions', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('description');

    $table->timestamps();
});

migrate('role_permissions', function($table) {
    $table->increments('id');
    $table->unsignedInteger('role_id');
    $table->unsignedInteger('permission_id');
    $table->enum('status', ['active', 'inactive'])->default('active');

    $table->timestamps();
});

redirect('/index.php?page=install/step-two');