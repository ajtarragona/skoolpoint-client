<?php

namespace Ajtarragona\Skoolpoint;

use Ajtarragona\Skoolpoint\Models\Center;
use Ajtarragona\Skoolpoint\Models\Oferta;
use Ajtarragona\Skoolpoint\Models\Solicitud;
use Ajtarragona\Skoolpoint\Traits\IsRestClient;
use Illuminate\Support\Str;

class SkoolpointService
{

    use IsRestClient;



	public function getCenters($options=[]){
        return Center::all($options['pagina']??1, $options['limit']??20);
		
    }
    public function getCenter($codi_centre){
        return $this->getCenters()->filter(function($center) use($codi_centre){
             return $center->codi ==$codi_centre;
        })->first();
		
    }

    public function searchCenters($term, $options=[]){
        return $this->getCenters()->filter(function($center) use($term){
            return Str::contains( strtoupper($center->nom), strtoupper($term));
       });
    }


    public function getOfertaCenter($codi_centre){
        return Oferta::getOfCenter($codi_centre);
		
    }

    public function getSolicituds($codi_centre, $state_name, $options=[]){
        return Solicitud::getByState($codi_centre, $state_name, $options);
		
    }

     
    public function getSolicitudsRegistrades($codi_centre, $options=[]){
        return Solicitud::getRegistrades($codi_centre, $options);
    }

    public function getSolicitudsValidades($codi_centre, $options=[]){
        return Solicitud::getValidades($codi_centre, $options);
    }

    public function getSolicitudsPendentsReclamacioBarem($codi_centre, $options=[]){
        return Solicitud::getPendentsReclamacioBarem($codi_centre, $options);
    }

    public function getSolicitudsPendentsReclamacioAssignacio($codi_centre, $options=[]){
        return Solicitud::getPendentsReclamacioAssignacio($codi_centre, $options);
    }

    public function getSolicitudsPendentsAssignacio($codi_centre, $options=[]){
        return Solicitud::getPendentsAssignacio($codi_centre, $options);
    }

    public function getSolicitudsPendentsMatricula($codi_centre, $options=[]){
        return Solicitud::getPendentsMatricula($codi_centre, $options);
    }

    public function getSolicitudsLlistaEspera($codi_centre, $options=[]){
        return Solicitud::getLlistaEspera($codi_centre, $options);
    }

    public function getSolicitudsAssignades($codi_centre, $options=[]){
        return Solicitud::getAssignades($codi_centre, $options);
    }

    public function getSolicitudsNoAssignades($codi_centre, $options=[]){
        return Solicitud::getNoAssignades($codi_centre, $options);
    }

    public function getSolicitudsTancades($codi_centre, $options=[]){
        return Solicitud::getTancades($codi_centre, $options);
    }

    public function getSolicitudsMatriculades($codi_centre, $options=[]){
        return Solicitud::getMatriculades($codi_centre, $options);
    }

}