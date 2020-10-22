<?php

namespace Ajtarragona\MailRelay\Models;

class MediaFile extends RestModel
{
    protected $model_name="media_files";

   // Atributos retornados por el servicio
   protected $attributes = ["id","media_folder_id","url","thumb_url","media_file_name","media_content_type","media_file_size","width","height","created_at","updated_at"];
   
   //atributos rellenables en el update o create
   protected $fillable = ["media_folder_id", "file"];
  
   protected $dates = ["created_at","updated_at"];


    /**
     * Uploads an image in MailRelay
     * $filename    : name of the file created in MailRelay
     * $content : must be the binaty content of the image
     */
    public static function createFromContent($filename, $content, $media_folder_id=0){
        
        return parent::create([
            "file" => [
                "name" => $filename,
                "content" => base64_encode($content)
            ],
            "media_folder_id" => $media_folder_id
            ]);
    }
    
    

    /**
     * Uploads from an UploadedFile
     */
    public static function createFromUpload($filename, $uploaded_file, $media_folder_id=0){
        //TODO

    }

    
}