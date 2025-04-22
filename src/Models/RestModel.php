<?php

namespace Ajtarragona\Skoolpoint\Models;

use Ajtarragona\Skoolpoint\Traits\IsRestClient;
use Carbon\Carbon;
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

    protected $dates = ["created_at","updated_at"];


    protected static function castAll($array){
        $ret=collect();
        if($array && is_array($array)) {
            foreach($array as $item){
                $ret->push(self::cast($item));
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
            
            //parseo las fechas
            if($model->{$attribute} && in_array($attribute, $model->dates)){
                $model->{$attribute} = Carbon::parse($model->{$attribute});
            }
        }
        return $model;
    }


    
    private function prepareArguments($values=null){
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


    
    public static function all($page=null, $per_page=null){
        $model=new static;
        $ret=$model->call('GET',$model->model_name,[
            'form_params' => [
                'pagina' => $page ,
                'limit' => $per_page
            ]
        ]);
		return self::castAll($ret);
    }



    /**
     * Busca mediante parámetros 
     */
    public static function search($parameters=[], $page=null, $per_page=null){
        $model=new static;
        $ret=$model->call('GET',$model->model_name,[
            'form_params' => [
                'q' => $parameters,
                'pagina' => $page ,
                'limit' => $per_page
            ]
        ]);
		return self::castAll($ret);
    }


    public static function find($id){
        $model=new static;
        $ret=$model->call('GET',$model->model_name.'/'.$id);
        // dd($ret);6
		return self::cast($ret);
    }





    public static function create(array $values=[]){
        $model=new static;
        
        $args=$model->prepareArguments($values);
        $ret=$model->call('POST',$model->model_name, $args);

        return self::cast($ret);
    }





    public function update(array $values=[]){
        return self::updateStatic($this->{$this->pk}, $values );
    }


    public static function updateStatic($id, array $values){
        $model=new static;
        $args=$model->prepareArguments($values);
        $ret=$model->call('PATCH',$model->model_name.'/'.$id, $args);
            
        return self::cast($ret);
    }




    public function delete(array $values=[]){
        return self::destroy($this->{$this->pk}, $values );
    }


    public static function destroy($id, array $values=[]){
        $model=new static;
        $args=$model->prepareArguments($values);
        // dump($args);
        $ret=$model->call('DELETE',$model->model_name.'/'.$id, $args);
        
        //nul serà si no troba l'ID
        return is_null($ret)?false:true;
    }


    
}