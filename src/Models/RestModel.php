<?php

namespace Ajtarragona\MailRelay\Models;

use Ajtarragona\MailRelay\Traits\IsRestClient;
use Illuminate\Support\Arr;

class RestModel
{
    use IsRestClient;

    protected $model_name;
    protected $pk ="id";

    // Atributos retornados por el servicio
    protected $attributes = ["id","created_at","updated_at"];

    //atributos rellenables en el update o create
    protected $fillable = [];


    protected static function castAll($array){
        $ret=[];
        if($array && is_array($array)) {
            foreach($array as $item){
                $ret[]=self::cast($item);
            }
        }
        return $ret;
    }


    protected static function cast($object){
        if(!$object) return null;
        if(!is_object($object)) return null;

        $model=new static;
        foreach($model->attributes as $attribute){
            $model->{$attribute} = $object->{$attribute} ?? null;
        }
        return $model;
    }


    
    private function prepareArguments(array $values=null){
        $ret=[];
        if($values){
            //filtro solo los valores que esten definidos como atributos
            $values = Arr::only($values, $this->fillable);
            $ret=[
                "json" => $values
            ];
        }
        return $ret;
    }


    
    public static function all(){
        $model=new static;
        $ret=$model->call('GET',$model->model_name);
		return self::castAll($ret);
    }


    public static function find($id){
        $model=new static;
        $ret=$model->call('GET',$model->model_name.'/'.$id);
		return self::cast($ret);
    }





    public static function create(array $values=null){
        $model=new static;
        
        $args=$model->prepareArguments($values);
        $ret=$model->call('POST',$model->model_name, $args);

        return self::cast($ret);
    }





    public function update(array $values=null){
        return self::updateStatic($this->{$this->pk}, $values );
    }


    public static function updateStatic($id, array $values){
        $model=new static;
        $args=$model->prepareArguments($values);
        $ret=$model->call('PATCH',$model->model_name.'/'.$id, $args);
            
        return self::cast($ret);
    }




    public function delete(array $values=null){
        return self::destroy($this->{$this->pk}, $values );
    }


    public static function destroy($id, array $values=null){
        $model=new static;
        $args=$model->prepareArguments($values);
        $ret=$model->call('DELETE',$model->model_name.'/'.$id, $args);
        
        //nul serà si no troba l'ID
        return is_null($ret)?false:true;
    }


    
}