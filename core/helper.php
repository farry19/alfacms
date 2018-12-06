<?php

// Helper file
// - will contain helping function available inside overall system

$base_url = '';
$root = '';

function resolve($core_class, $constructor = NULL)
{
    return new $core_class($constructor);
}

function migrate($table, $structure_callback)
{
    $schema = resolve('\\Core\\Database\\DB')->schema();
    $schema->create($table, $structure_callback);
}

function base($dir, $base)
{
    global $base_url;
    global $root;
    $root = $dir;
    $dir = str_replace("\\", "/", $dir);
    $dir = str_replace($base, '', $dir);
    $base_url = $dir;
}

function root()
{
	global $root;
	return $root;
}

function url($link = '')
{
    global $base_url;
    return $base_url.$link;
}

function config($key)
{
	return \Core\Config::get($key);
}

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}