<?php

namespace Ajtarragona\MailRelay\Models;

class Subscriber extends RestModel
{
    protected $model_name="subscribers";

      // Atributos retornados por el servicio
      protected $attributes = ["id","email","name","score","status","subscribed_at","subscribed_with_acceptance","subscribe_ip","unsubscribed","unsubscribed_at","unsubscribe_ip","unsubscribe_sent_email_id","address","city","state","country","birthday","website","bounced","reported_spam","local_ban","global_ban","created_at","updated_at","groups","custom_fields"];

      //atributos rellenables en el update o create
      protected $fillable = ["name","description"];
      protected $dates = ["status","email","name","address","city","state","country","birthday","website","group_ids"];

  


}