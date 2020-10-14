<?php

namespace Ajtarragona\MailRelay;

use Ajtarragona\MailRelay\Traits\IsRestClient;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Support\Str;

class MailRelayService
{

    use IsRestClient;


	protected $options;
	protected $client;
	protected $api_url;
	protected $api_key;
	


	public function __construct($options=array()) { 
		$opts=config('mailrelay');
		if($options) $opts=array_merge($opts,$options);
		$this->options= json_decode(json_encode($opts), FALSE);
        // dump($this->options);
		$this->debug = $this->options->debug;
		$this->api_url = rtrim($this->options->api_url,"/")."/"; //le quito la barra final si la tiene y se la vuelvo a poner. Asi me aseguro que siempre acaba en barra.
		$this->api_key = $this->options->api_key;
        
	}





    /**
     * Retorna todos los remitentes
     */
	public function getSenders(){
		$ret=$this->call('GET','senders');
		return $ret;
    }

    

    /**
     * Añade un remitente
     */
	public function addSender($name, $email){
		$ret=$this->call('POST','senders',[
            "json" => [
                "name" => $name,
                "from_name" => $name,
                "email" => $email
            ]
        ]);
		return $ret;
    }
    

    /**
     * Retorna todos los custom_fields de Mailrelay
     */
    public function getCustomFields(){
		$ret=$this->call('GET','custom_fields');
		return $ret;
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
	public function addCustomField($name, $label, $type="text", $required=false, $default_value="", $options=[]){
        
        $preparedOptions=[];
        if($options){
            foreach($options as $option){
                $preparedOptions[]=["label"=>$option];
            }
        }


        $ret=$this->call('POST','custom_fields',[
            "json" => [
                "label" => $label,
                "tag_name" => Str::snake($name),
                "field_type" => $type, //(text, textarea, number, select, select_multiple, checkbox, radio_buttons, date
                "required" => $required,
                "default_value" => $default_value,
                "custom_field_options_attributes" => $preparedOptions
            ]
        ]);
		return $ret;
    }


    


}