<?php

namespace Ajtarragona\MailRelay\Models;

class SentCampaign extends RestModel
{
    protected $model_name="sent_campaigns";

      // Atributos retornados por el servicio
      protected $attributes = ['id','subject','sender_id','preview_text','html','status','clicks_count','unique_clicks_count','impressions_count','unique_impressions_count','sent_emails_count','unsubscribe_events_count','scheduled_at', 'created_at' ,'updated_at', 'finished_at'];

      protected $dates = ['scheduled_at', 'created_at' ,'updated_at', 'finished_at'];

      protected $fillable = [];

      /** No tiene create */
      public static function create(array $values=[]){
         return false;  
      }

      /* NO tiene update */
      public static function updateStatic($id, array $values){
         return false;
       }
 
       /* NO tiene delete */
       public static function destroy($id, array $values=[]){
         return false;
       }


       
      /**
       * Get sent campaign's clicks.
       */
      public function clicks(){
        return $this->call('GET', $this->model_name.'/'.$this->id.'/clicks');
      }

      /**
       * Get sent campaign's impressions.
       */
      public function impressions(){
        return $this->call('GET', $this->model_name.'/'.$this->id.'/impressions');
      }

      /**
       * Get sent campaign's sent_emails.
       */
      public function sent_emails(){
        return $this->call('GET', $this->model_name.'/'.$this->id.'/sent_emails');
      }

      /**
       * Get sent campaign's unsubscribe_events.
       */
      public function unsubscribe_events(){
        return $this->call('GET', $this->model_name.'/'.$this->id.'/unsubscribe_events');
      }
}