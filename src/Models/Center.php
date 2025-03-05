<?php

namespace Ajtarragona\Skoolpoint\Models;

class Center extends RestModel
{
    protected $model_name="centres";

      // Atributos retornados por el servicio
      protected $attributes = ["codi","nom","adreca","telefon","email","responsable"];

      //atributos rellenables en el update o create
      protected $fillable = ["codi","nom","adreca","telefon","email","responsable"];
 

      
}