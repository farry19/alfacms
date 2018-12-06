<?php

namespace Core\Util;

class ErrorView
{

	public static function render($title, $description)
	{
		echo '<link href="'.url('/admin/css/bootstrap.css').'" rel="stylesheet"/>
				<div class="jumbotron">
                  <h1 class="display-4">'.$title.'</h1>
                  <p class="lead">'.$description.'</p>
                </div>';
        exit;
	}

}