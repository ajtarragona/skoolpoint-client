<?php

namespace Ajtarragona\MailRelay;

use Ajtarragona\MailRelay\Models\Campaign;
use Ajtarragona\MailRelay\Models\CustomField;
use Ajtarragona\MailRelay\Models\Group;
use Ajtarragona\MailRelay\Models\Sender;
use Ajtarragona\MailRelay\Traits\IsRestClient;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Support\Str;

class MailRelayService
{

    use IsRestClient;




    /**
     * Retorna todos los remitentes
     */
	public function getSenders(){
        return Sender::all();
		
    }

    
    /**
     * Retorna un remitente
     */
	public function getSender($id){
        return Sender::find($id);
		
    }

    

    /**
     * Añade un remitente
     */
	public function createSender($name, $email){
		return Sender::create([
            "name" => $name,
            "from_name" => $name,
            "email" => $email
        ]);
        
    }
    




    /**
     * Retorna todos los custom_fields de Mailrelay
     */
    public function getCustomFields(){
		return CustomField::all();
		
    }
    

    /**
     * Retorna un custom_fields
     */
	public function getCustomField($id){
        return CustomField::find($id);
		
    }


    /**
     * Añade un custom field a mailrelay
     * $name: nombre corto interno
     * $label: nombre visible
     * $type : text, textarea, number, select, select_multiple, checkbox, radio_buttons, date
     * 
     * En caso de ser select, select_multiple, checkbox o radio_buttons
     * $options es un array con los nombres de las opciones
     */
	public function createCustomField($name, $label, $type="text", $required=false, $default_value="", $options=[]){
        
        $preparedOptions=[];
        if($options){
            foreach($options as $option){
                $preparedOptions[]=["label"=>$option];
            }
        }


        return CustomField::create([
            "label" => $label,
            "tag_name" => Str::snake($name),
            "field_type" => $type, //(text, textarea, number, select, select_multiple, checkbox, radio_buttons, date
            "required" => $required,
            "default_value" => $default_value,
            "custom_field_options_attributes" => $preparedOptions
        ]);
        
        
    }






    
    /**
     * Retorna todos los grupos
     */
	public function getGroups(){
        return Group::all();
		
    }

    
    /**
     * Retorna un grupo
     */
	public function getGroup($id){
        return Group::find($id);
		
    }

    

    /**
     * Añade un grupo
     */
	public function createGroup($name, $description=null){
		return Group::create([
            "name" => $name,
            "description" => $description
        ]);
        
    }
    


     /**
     * Retorna todoslos boletines
     */
	public function getCampaigns(){
        return Campaign::all();
		
    }

    
    /**
     * Retorna un boletin
     */
	public function getCampaign($id){
        return Campaign::find($id);
		
    }

    

    /**
     * Añade un boletin
     */
	public function createCampaign($subject, $body, $sender_id, $group_ids=[], $target="groups", $attributes=[]){
		return Campaign::create(array_merge([
            "subject" => $subject,
            "html" => $body,
            "sender_id" => $sender_id,
            "group_ids" => $group_ids,
            "target" => $target,
        ], $attributes));
        
    }
    


}