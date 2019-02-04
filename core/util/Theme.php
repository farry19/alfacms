<?php
namespace Core\Util;

class Theme
{

	private $path;

	function __construct($theme_path = '')
	{
		$this->path = $theme_path;
	}

	public function render($file)
	{
		return $this->parse($this->path . $file . '.php');
	}

	public function parse($file, $data = null, $renderable = true) {

		// Data 
		//echo $file . '<br/>';		
		if(isset($_GET['data'])){
			$data = json_decode(urldecode($_GET['data']));
			//var_dump(json_decode(urldecode($_GET['data'])));
			if($data != NULL){
				foreach($data as $key => $value){
					//echo $key;
					$$key = $value;
				}
			}
		}

		$output = '';
		ob_start();
		include_once $file;
		$output = ob_get_clean();	

        $includes = match($output,'*@include(?)*',TRUE);
        $phpShortEchos = match($output,'*{{?}}*',TRUE);
		$phpIf = match($output,'*@if(?)',TRUE);
		$phpFor = match($output,'*@for(?)',TRUE);
		$phpForEach = match($output,'*@foreach(?)',TRUE);
		$phpElseIf = match($output,'*@elseif(?)',TRUE);
        
        $output = str_replace("~", url('/public/'), $output);
        $output = str_replace("url:", url('') ."/", $output);
        if(is_array($includes)){
	        foreach($includes as $inc){
	        	$output = str_replace("@include(".$inc.")", self::parse($this->path . $inc . '.php',null,false), $output);
			}
		}
	    if(is_array($phpIf)){
	        for($i=0;$i<count($phpIf);$i++){
	        	$temp = $phpIf[$i];
	        	$output = str_replace("@if(".$temp.")", "<?php if(".$temp."){ ?>", $output);
			}
		}
		if(is_array($phpElseIf)){
	        for($i=0;$i<count($phpElseIf);$i++){
	        	$temp = $phpElseIf[$i];
	        	$output = str_replace("@elseif(".$temp.")", "<?php }elseif(".$temp."){ ?>", $output);
			}
		}
		if(is_array($phpFor)){
	        for($i=0;$i<count($phpFor);$i++){
	        	$temp = $phpFor[$i];
	        	$output = str_replace("@for(".$temp.")", "<?php for(".$temp."){ ?>", $output);
			} 
		}
		if(is_array($phpForEach)){
	        for($i=0;$i<count($phpForEach);$i++){
	        	$temp = $phpForEach[$i];
	        	$output = str_replace("@foreach(".$temp.")", "<?php foreach(".$temp."){ ?>", $output);
			}
		}
	    if(is_array($phpShortEchos)){
	        foreach($phpShortEchos as $pse){
	        	$code = '<?php echo '.$pse.'; ?>';
	        	$output = str_replace("{{".$pse."}}", $code, $output);
			}
		}
		// Few Replacements
		$output = str_replace("@endif", '<?php } ?>', $output);
		$output = str_replace("@endforeach", '<?php } ?>', $output);
		$output = str_replace("@endfor", '<?php } ?>', $output);
		$output = str_replace("@else", '<?php }else{ ?>', $output);		
		$output = str_replace("@php", '<?php ', $output);
		$output = str_replace("@endphp", ' ?>', $output);
		if(!$renderable)
			return $output;

		$ext = explode('.', $file);
		$filename = $ext[0];
		$extension = $ext[1];
		$new_filename = $filename . '.ren';
		$file_handle = fopen($new_filename ,"w");
		fwrite($file_handle, $output);
		fclose($file_handle);

		ob_start();
		include_once $new_filename;
		$output = ob_get_clean();
		return $output;
	}

}