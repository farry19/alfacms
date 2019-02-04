<?php
if (!file_exists('vendor/autoload.php' )){
	echo "Please run command `composer install` from console.";
	exit;
}
require 'vendor/autoload.php';

// Basic configurations
use Core\Config;
base(__DIR__, $_SERVER['DOCUMENT_ROOT']);
Config::initialize();

use Core\App;
use Core\Util\Installer;

// Routing via GET i.e. ?page=something
App::route();

// Checking installation
$installer = new Installer;
if(!$installer->installed())
{
	$installer->install();
}

// Boot up application with theme
App::boot();


