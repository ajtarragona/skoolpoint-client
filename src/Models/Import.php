<?php

namespace Ajtarragona\MailRelay\Models;

class Import extends RestModel
{
    protected $model_name="imports";

      // Atributos retornados por el servicio
      protected $attributes = ["id","name","number_of_records","status", "finished_at", "created_at", "updated_at", "file", "file_name", "file_size", "import_fields"];
     
     

      //atributos rellenables en el update o create
      protected $fillable = ["file", "existing_subscribers", "callback_url", "import_fields_attributes", "group_ids"];
  

      protected $dates = ["finished_at","created_at","updated_at"];



      /* NO tiene update */
      public static function updateStatic($id, array $values){
        return false;
      }

      /* NO tiene delete */
      public static function destroy($id, array $values=[]){
        return false;
      }



      /**
       * Creates an import in MailRelay
       * $filename    : name of the file created in MailRelay
       * $subscribers : must be an array of subscribers. 
       *                Each row must have the same key=>value fields. 
       *                Custom fields key shold be: custom_field_ID
       * $group_ids:    array of group IDs the users will be subscribed to
       * $callback:     url
       * $ignore:       by default existing users will be ignored
       */
      public static function doCreate($filename, $subscribers, $group_ids=[], $callback=null, $ignore=true){
      
        if($subscribers && is_array($subscribers)){
          // dd($subscribers);
          $content = base64_encode(array_to_csv($subscribers,';'));
          $keys=array_keys($subscribers[0]);
          // dump($content);
          
          $import_plan=[];
          foreach($keys as $i=>$key){
            $import_plan[]=[
              "column" => $i,
              "field"=> $key
            ];
          }

          // dd($import_plan);
          
          $options=[
            "file"=> [
              "name"=> $filename.".csv",
              "content"=> $content,
            ],
            "existing_subscribers" => ($ignore?"ignore":"replace"),
            "callback_url" => $callback,
            "import_fields_attributes" => $import_plan,
            "group_ids" => $group_ids
          ];

          // dd($options);
          return Import::create($options);
        }
        return false;
      
      }


      

      /**
       * Cancel a import that is in progress
       * This will stop and permanently cancel a import. It can't be resumed later.
       */
      public function cancel(){
        return $this->call('PATCH', $this->model_name.'/'.$this->id.'/cancel');
      }


      /**
       * Get line by line data of a import.
       */
      public function data(){
        return $this->call('GET', $this->model_name.'/'.$this->id.'/data');
      }
}