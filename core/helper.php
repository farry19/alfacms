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