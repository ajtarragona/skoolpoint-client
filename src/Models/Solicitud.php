<?php

namespace Ajtarragona\Skoolpoint\Models;
use Skoolpoint;



class Solicitud extends RestModel
{
    protected $model_name="sollicituds";

    public static  $ESTAT_REGISTRADES =  "registrades";
    public static  $ESTAT_VALIDADES =  "validades";
    public static  $ESTAT_PENDENTS_RECLAMACIO_BAREM =  "pendents/reclamacioBarem";
    public static  $ESTAT_PENDENTS_RECLAMACIO_ASSIGNACIO =  "pendents/reclamacioAssignacio";
    public static  $ESTAT_PENDENTS_ASSIGNACIO =  "pendents/assignacio";
    public static  $ESTAT_PENDENTS_MATRICULA =  "pendents/matricula";
    public static  $ESTAT_LLISTA_ESPERA =  "llistaEspera";
    public static  $ESTAT_ASSIGNADES =  "assignades";
    public static  $ESTAT_NO_ASSIGNADES =  "noAssignades";
    public static  $ESTAT_TANCADES =  "tancades";
    public static  $ESTAT_MATRICULADES =  "matriculades";

   
      // Atributos retornados por el servicio
    protected $attributes = ["total","count","data"];

      
    public static function getByState($codi, $state_name, $options=[]){
        $model=new static;
        $ret=$model->call('POST',$model->model_name.'/'.$state_name,[
          'form_params' => [
              'centre' => $codi,
              'tutors'=> isTrue($options['tutors']??true),
              'nese'=> isTrue($options['nese']??false),
              'pagina' => $options['pagina']??1,
              'limit' => $options['limit']??20
          ]
      ]);

      return self::cast($ret);
    }

    public static function getRegistrades($codi, $options=[]){
        return self::getByState($codi, self::$ESTAT_REGISTRADES , $options);
    }

    public static function getValidades($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_VALIDADES, $options);
    }

    public static function getPendentsReclamacioBarem($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_PENDENTS_RECLAMACIO_BAREM, $options);
    }

    public static function getPendentsReclamacioAssignacio($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_PENDENTS_RECLAMACIO_ASSIGNACIO, $options);
    }

    public static function getPendentsAssignacio($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_PENDENTS_ASSIGNACIO, $options);
    }

    public static function getPendentsMatricula($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_PENDENTS_MATRICULA, $options);
    }

    public static function getLlistaEspera($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_LLISTA_ESPERA, $options);
    }

    public static function getAssignades($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_ASSIGNADES, $options);
    }

    public static function getNoAssignades($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_NO_ASSIGNADES, $options);
    }

    public static function getTancades($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_TANCADES, $options);
    }

    public static function getMatriculades($codi, $options=[]){
      return self::getByState($codi, self::$ESTAT_MATRICULADES, $options);
    }

      
}