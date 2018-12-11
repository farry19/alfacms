<?php
require 'vendor/autoload.php';

// Basic configurations
use Core\Config;
base(__DIR__, $_SERVER['DOCUMENT_ROOT']);
Config::initialize();

use Core\App;
use Core\Util\Installer;

// @farrukh, we need to improve routing experience overall
// it will help us & developers for theme development, seo friendly urls,
// over website functionality for navigations (GET, POST, PUT, PATCH, DELETE)
// not to mention, plugins development.

// Checking installation
// NOTE: installer is currently only checktion for existance of
// one table named "options"
// TODO: need to check overall schema to verify installation.
$installer = new Installer;
if(!$installer->installed())
{
	$installer->install();
}

// Routing via GET i.e. ?page=something
App::route();

// Boot up application with theme
App::boot();


