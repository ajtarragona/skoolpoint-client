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