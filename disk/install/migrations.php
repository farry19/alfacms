<?php

//$db = resolve('\Core\Database\DB');
use \Core\Database\DB;

$query_string = 'create table options (
	id int(11) primary key auto_increment NOT NULL,
	name varchar(255) NOT NULL,
	value varchar(255)
);';

//$db->default()->query($query_string);

$query_string = 'create table items (
  id int(11) primary key auto_increment NOT NULL,
  title varchar(255) NOT NULL,
  body text NULL,
  status enum("draft", "unpublished", "published") default "draft",
  password varchar(255) NULL,
  user_id int(11) unsigned NOT NULL,
  category_id int(11) unsigned NULL,
  post_image int(11) unsigned NULL,
  created_at datetime CURRENT_TIMESTAMP,
  updated_at datetime CURRENT_TIMESTAMP
);';

//$db->default()->query($query_string);

$query_string = 'create table categories (
  id int(11) primary auto_increment NOT NULL,
  title varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  status enum("active", "inactive") default "active",
  user_id int(11) unsigned NOT NULL,
  category_image int(11) unsigned NULL,
  created_at datetime CURRENT_TIMESTAMP,
  updated_at datetime CURRENT_TIMESTAMP
);';

//$db->default()->query($query_string);

$query_string = 'create table meta (
  id int(11) primary key auto_increment NOT NULL,
  key varchar(255) NOT NULL,
  value text NULL,
  item_id int(11) unsigned NOT NULL,
  created_at datetime CURRENT_TIMESTAMP,
  updated_at datetime CURRENT_TIMESTAMP
);';

//$db->default()->query($query_string);

$query_string = 'create table media (
  id int(11) primary key auto_increment NOT NULL,
  path varchar(255) NOT NULL,
  ext char(4) NOT NULL,
  created_at datetime CURRENT_TIMESTAMP,
  updated_at datetime CURRENT_TIMESTAMP
);';

$db->default()->query($query_string);

header('Location: ' . url('/index.php?page=install/step-two'));
exit;