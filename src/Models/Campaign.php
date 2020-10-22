<?php

namespace Ajtarragona\MailRelay\Models;

class Campaign extends RestModel
{
    protected $model_name="campaigns";

      // Atributos retornados por el servicio
      protected $attributes = ["id","subject","sender_id","campaign_folder_id","target","segment_id","group_ids","preview_text","html","editor_type","url_token","analytics_utm_campaign","use_premailer"];

      //atributos rellenables en el update o create
      protected $fillable = ["subject","sender_id","campaign_folder_id","target","segment_id","group_ids","preview_text","html","editor_type","url_token","analytics_utm_campaign","use_premailer"];
  

      

      /**
       * Envia el boletín
       * 
       */
      public function send($attributes=[]){
         
         $args = array_merge([
          "target" => "groups",
          "group_ids" => [],
          "segment_id" => null,
          "scheduled_at" => null,
          "callback_url" =>	null
          ],$attributes);

         if(isset($args["target"]) && $args["target"] && isset($args["group_ids"]) && $args["group_ids"] ){

            $ret=$this->call('POST', $this->model_name.'/'.$this->id.'/send_all', [
               "json" =>$args 
            ]);
   
            return self::cast($ret);
         }

         return false;
  
      }
}