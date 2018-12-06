<?php

migrate('options', function($table){
	$table->increments('id');
	$table->string('name');
	$table->string('value');
});

// TODO: add all other database tables
// @farrukh, can you please takecare of tables?

header('Location: ' . url('/index.php?page=install/step-two'));
exit;