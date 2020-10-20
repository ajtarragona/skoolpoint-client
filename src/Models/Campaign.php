<?php

namespace Ajtarragona\MailRelay\Models;

class Campaign extends RestModel
{
    protected $model_name="campaigns";

      // Atributos retornados por el servicio
      protected $attributes = ["id","subject","sender_id","campaign_folder_id","target","segment_id","group_ids","preview_text","html","editor_type","url_token","analytics_utm_campaign","use_premailer"];

      //atributos rellenables en el update o create
      protected $fillable = ["subject","sender_id","campaign_folder_id","target","segment_id","group_ids","preview_text","html","editor_type","url_token","analytics_utm_campaign","use_premailer"];
  
}