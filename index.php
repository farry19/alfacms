<?php
require 'vendor/autoload.php';

// Basic configurations
use Core\Config;
base(__DIR__, $_SERVER['DOCUMENT_ROOT']);
Config::initialize();

use Core\App;
use Core\Util\Installer;

// Checking installation
$installer = new Installer;
if(!$installer->installed())
{
	$installer->install();
}

// Booting the theme
App::boot();


