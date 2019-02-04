<?php

// Helper file
// - will contain helping function available inside overall system

$base_url = '';
$root = '';

// Session global helpers
session_start();
function session($key, $value = NULL)
{
    // Get session
    if($value == NULL)
        return $_SESSION[$key];
    // Set session
    $_SESSION[$key] = $value;
}

function sessionHas($key)
{
    if(isset($_SESSION[$key]))
        return true;
    return false;
}

function sessionFlush()
{
    session_destroy();
}

// tiny controllers mapper
function requestMap($request_names, $class)
{
    $class_instance = new $class();
    if(is_array($request_names))
    {
        foreach($request_names as $request)
        {
            if(method_exists($class_instance, $request) && $_GET['request'] == $request)
            {
                // Grab all GETS & POSTS
                $request_object = new \StdClass;
                foreach($_POST as $key => $value)
                {
                    $request_object->$key = $value;
                }
                foreach($_GET as $key => $value)
                {
                    $request_object->$key = $value;
                }
                echo $class_instance->$request($request_object);
                exit;
            }
        }
    }
}

function resolve($core_class, $constructor = NULL)
{
    return new $core_class($constructor);
}

function route($page)
{
    $theme = \Core\Util\Theme();
    $theme->redner($page);
}

function migrate($table, $query_string)
{
    $schema = \Core\Database\DB::schema();
    $schema->create($table, $query_string);
}

function seed($table, $query_string)
{
    $schema = \Core\Database\DB::query();
    $schema->query($table, $query_string);
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

function config($key, $value = NULL)
{   
    if($value != NULL)
        \Core\Config::set($key, $value);
	return \Core\Config::get($key);
}

function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    exit;
}

function redirect($url = '/')
{
    header('Location: ' . url($url));
    exit;
}

function get($name)
{
    return $_GET[$name];
}

function view($name, $data = NULL, $type = 'admin')
{
    $controllerName = explode('/', $_GET['page']);
    $currentRoute = $controllerName[1] . '@' . $_GET['request'];   
    //echo config('BASE').'/index.php?target='.$type.'&page='.$name.'&route=' . $currentRoute . '&data=' . base64_encode(json_encode($data)); 
    $output = file_get_contents(config('BASE').'/index.php?target='.$type.'&page='.$name.'&route=' . $currentRoute . '&data=' . urlencode(json_encode($data)));
    //exit;
    echo $output;
    exit;
}

function to($name, $request)
{
    return '/?target=admin&page=controllers/'.$name.'&request='.$request;
}

function controller($name, $request)
{
    redirect('/?target=admin&page=controllers/'.$name.'&request='.$request);
}

function redirectPage($name, $type = 'admin')
{
    redirect('/?target='.$type.'&page='.$name);
}

function match($string, $condition, $recursive = FALSE)
{
    $gotStrings = Array();
    $gotCount = -1;
    if(strlen($condition)<1)
        return FALSE;
   $index = 0;
   $resetPoint = 0;
    $findNext = $condition[$index];
    $expecting = 'exact_match';
    if($findNext=='*'){
        $expecting = 'anything';
        if(isset($condition[$index+1]))
            $findNext = $condition[++$index];
    }
    if($findNext=='?'){
        $gotCount++;
        $gotStrings[$gotCount] = '';
       $expecting = 'get';      
        if(isset($condition[$index+1])){
           $resetPoint = $index+1;
            $findNext = $condition[++$index];
        }elseif ($recursive){
            $index = 0;
            $findNext = $condition[$index];
        }
    }
    for ($i=0; $i < strlen($string); $i++) {        
        $char = $string[$i];
        //echo "FN: ".$findNext." ACTUAL: ".$char." --exp ".$expecting." ".($findNext==$char?'<i style="color: green">MATCHED</i>':'')."<br/>";
        if($expecting=='get' && $findNext != $char){
            $gotStrings[$gotCount] = $gotStrings[$gotCount] . $char;
        }
        if($findNext == $char){
            $expecting = 'exact_match';
            if(isset($condition[$index+1]) && $i < strlen($string) -1){
                $findNext = $condition[++$index];
            }elseif ($recursive){
                $index = 0;
                $findNext = $condition[$index];
            }
            if($findNext=='*'){
                $expecting = 'anything';
                if(isset($condition[$index+1])){
                    $findNext = $condition[++$index];
                }elseif ($recursive){
                    $index = 0;
                    $findNext = $condition[$index];
                    if($findNext=='*'){
                        $expecting = 'anything';
                        if(isset($condition[$index+1]))
                            $findNext = $condition[++$index];
                    }
                }
            }
            if($findNext=='?'){
                $gotCount++;
                $gotStrings[$gotCount] = '';
                $expecting = 'get';
                if(isset($condition[$index+1])){
                   $resetPoint = $index+1;
                    $findNext = $condition[++$index];
                }elseif ($recursive){
                    $index = 0;
                    $findNext = $condition[$index];
                }
            }
        }else{
            if($expecting == 'exact_match' && !$recursive)
                return FALSE;
            if($expecting == 'exact_match' && $recursive){
                    $index = $resetPoint;
                    $findNext = $condition[$index];
                    if($findNext=='*'){
                        $expecting = 'anything';
                        if(isset($condition[$index+1]))
                            $findNext = $condition[++$index];
                    }
                }
        }
    }
    if(count($gotStrings)>0 && $recursive)
            return $gotStrings;
    if($index == strlen($condition)-1){
        if(count($gotStrings)>0)
            return $gotStrings;
        return TRUE;
    }
    return FALSE;
}