<?php

namespace Ajtarragona\Skoolpoint;

use Ajtarragona\Skoolpoint\Models\Center;
use Ajtarragona\Skoolpoint\Traits\IsRestClient;
use Illuminate\Support\Str;

class SkoolpointService
{

    use IsRestClient;




    /**
     * Retorna todos los remitentes
     */
	public function getCenters($page=null, $per_page=null){
        return Center::all($page, $per_page);
		
    }
   

}