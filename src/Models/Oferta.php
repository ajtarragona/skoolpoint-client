<?php

namespace Ajtarragona\Skoolpoint\Models;

use Illuminate\Support\Arr;

class Oferta extends RestModel
{
    protected $model_name="oferta";

    protected $attributes = ["centre","codi","cursos","totals"];


    public static function getOfCenter($id){
      $model=new static;
      $ret=$model->call('GET',$model->model_name.'/'.$id);
      if($ret && is_array($ret)) $ret=Arr::first($ret);
      return self::cast($ret);
  }

      
}