<?php

namespace Ajtarragona\MailRelay\Models;

class Group extends RestModel
{
    protected $model_name="groups";

      // Atributos retornados por el servicio
      protected $attributes = ["id","name","description","subscribers_count","created_at","updated_at"];

      //atributos rellenables en el update o create
      protected $fillable = ["name","description"];
  
}