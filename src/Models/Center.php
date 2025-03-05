<?php

namespace Ajtarragona\Skoolpoint\Models;
use Skoolpoint;



class Center extends RestModel
{
    protected $model_name="centres";

    public $codi;
    public $nom;
    public $adreca;
    public $telefon;
    public $email;
    public $responsable;


      // Atributos retornados por el servicio
      protected $attributes = ["codi","nom","adreca","telefon","email","responsable"];

      //atributos rellenables en el update o create
      protected $fillable = ["codi","nom","adreca","telefon","email","responsable"];
 

      public function getOferta(){
        return Oferta::getOfCenter($this->codi);
      }

      public function getSolicituds( $state_name, $options=[]){
        return Solicitud::getByState($this->codi, $state_name, $options);
		  }

        
      public function getSolicitudsRegistrades($options=[]){
          return self::getSolicituds(Solicitud::$ESTAT_REGISTRADES, $options);
      }
      
      public function getSolicitudsValidades($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_VALIDADES, $options);
      }

      public function getSolicitudsPendentsReclamacioBarem($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_PENDENTS_RECLAMACIO_BAREM, $options);
      }

      public function getSolicitudsPendentsReclamacioAssignacio($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_PENDENTS_RECLAMACIO_ASSIGNACIO, $options);
      }

      public function getSolicitudsPendentsAssignacio($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_PENDENTS_ASSIGNACIO, $options);
      }

      public function getSolicitudsPendentsMatricula($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_PENDENTS_MATRICULA, $options);
      }

      public function getSolicitudsLlistaEspera($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_LLISTA_ESPERA, $options);
      }

      public function getSolicitudsAssignades($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_ASSIGNADES, $options);
      }

      public function getSolicitudsNoAssignades($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_NO_ASSIGNADES, $options);
      }

      public function getSolicitudsTancades($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_TANCADES, $options);
      }

      public function getSolicitudsMatriculades($options=[]){
        return self::getSolicituds(Solicitud::$ESTAT_MATRICULADES, $options);
      }


      
}