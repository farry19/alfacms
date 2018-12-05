<?php

$db = resolve('\\Core\\Database\\DB');

$queryString = '
create table options (
	id INT(11) primary key auto_increment NOT NULL,
	name varchar(255) NOT NULL,
	value varchar(255)
);';
$db->default()->query($queryString);

// TODO: add all other database tables

header('Location: ' . url('/index.php?page=install/step-two'));
exit;