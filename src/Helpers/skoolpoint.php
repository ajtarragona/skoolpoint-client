<?php

if (! function_exists('skoolpoint')) {
	function skoolpoint($options=false){
		return new \Ajtarragona\Skoolpoint\SkoolpointService($options);
	}
}
