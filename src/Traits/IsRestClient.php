<?php

namespace Ajtarragona\MailRelay\Traits;

use Ajtarragona\MailRelay\Exceptions\MailRelayAuthException;
use Ajtarragona\MailRelay\Exceptions\MailRelayConnectionException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Log;
use Exception;
use GuzzleHttp\Exception\ClientException;

trait IsRestClient
{
	
	protected $client;
	protected $options;
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


	private function connect(){
		if(!$this->client){

			
			if($this->debug) Log::debug("MailRelay: Connecting to API:" .$this->api_url);


			$this->client = new Client([
				'base_uri' => $this->api_url
			]);
		
		}
	}
	

	private function call($method, $url, $args=[]){
		$url=ltrim($url,"/");
		if(!$url) return false;

		$this->connect();
		
		//forzar header json
		if(isset($args["headers"])){
			$args["headers"]=array_merge($args["headers"],[
				'X-AUTH-TOKEN' => $this->api_key,
				'Accept'     => 'application/json'
			]);
		}else{
			$args["headers"]=[
				'X-AUTH-TOKEN' => $this->api_key,
				'Accept'     => 'application/json'
			];
		}


		
		if($this->debug){
			Log::debug("MailRelay: Calling $method to url:" .$this->api_url."".$url);
			Log::debug("MailRelay: Options:");
			Log::debug($args);
		}
		

	
		
		$ret=false;

		try{
			$response = $this->client->request($method, $url, $args);
			if($this->debug){
				Log::debug("STATUS:".$response->getStatusCode());
				Log::debug("BODY:");
				Log::debug($response->getBody());
			}

			switch($response->getStatusCode()){
				case 200:
				case 201:
				case 204:
					$ret = (string) $response->getBody();
					
					if(isJson($ret)){
						$ret=json_decode($ret);
						
					}
					

					break;
				default: break;
			}

			return $ret;
		} catch (RequestException | ConnectException | ClientException $e) {
			
			return $this->parseException($e);
		   
		}
		
	}
	

	private function parseException($e){
		if($this->debug){
			Log::error("MailRelay API error");
			Log::error($e->getMessage());
		}
		// dd($e->hasResponse());
		if ($e->hasResponse()) {
			$status=$e->getResponse()->getStatusCode();
		   switch($status){
				   case 404:
					//si no se encuentra, soporto la excepcion y devuelvo null
					return null; 
				case 401:
					//Auth exception
					throw new MailRelayAuthException(__("Mailrelay exception: The API key wasn't sent or is invalid")); break;
				
				default: break;
				
		   }
		}else{
			throw new MailRelayConnectionException(__("Mailrelay connection exception"));
				
		}
		
	}

}