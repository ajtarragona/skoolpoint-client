<?php

namespace Ajtarragona\MailRelay\Models;

class CustomField extends RestModel
{
    protected $model_name="custom_fields";

      // Atributos retornados por el servicio
      protected $attributes = ["id","label","tag_name","field_type","required","default_value", "created_at","updated_at", "custom_field_options"];

      //atributos rellenables en el update o create
      protected $fillable = ["label","tag_name","field_type","required","default_value", "custom_field_options_attributes"];

}