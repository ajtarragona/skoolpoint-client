<?php

namespace Ajtarragona\MailRelay\Models;

class CampaignFolder extends RestModel
{
    protected $model_name="campaign_folders";

      // Atributos retornados por el servicio
      protected $attributes = ["id","name","created_at","updated_at"];

      //atributos rellenables en el update o create
      protected $fillable = ["name"];
  
}