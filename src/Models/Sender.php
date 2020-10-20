<?php

namespace Ajtarragona\MailRelay\Models;

class Sender extends RestModel
{
    protected $model_name="senders";

      // Atributos retornados por el servicio
      protected $attributes = ["id","name","from_name","email","default", "confirmed", "created_at","updated_at"];

      //atributos rellenables en el update o create
      protected $fillable = ["name","from_name","email"];
  
}