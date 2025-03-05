<?php

namespace Ajtarragona\Skoolpoint\Traits;

use Ajtarragona\Skoolpoint\Exceptions\SkoolpointAuthException;
use Ajtarragona\Skoolpoint\Exceptions\SkoolpointConnectionException;
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
	protected $api_user;
	protected $api_password;
	protected $api_token;
	protected $debug;
	


	public function __construct($options=array()) { 
		$opts=config('skoolpoint');
		if($options) $opts=array_merge($opts,$options);
		$this->options= json_decode(json_encode($opts), FALSE);
        // dump($this->options);
		$this->debug = $this->options->debug;
		$this->api_url = rtrim($this->options->api_url,"/")."/"; //le quito la barra final si la tiene y se la vuelvo a poner. Asi me aseguro que siempre acaba en barra.

		$this->api_user = $this->options->api_user;
		$this->api_password = $this->options->api_password;
		$this->api_token = $this->options->api_token;
        
	}


	private function connect(){
		if(!$this->client){

			
			if($this->debug) Log::debug("Skoolpoint: Connecting to API:" .$this->api_url);

			
			$this->client = new Client([
				'base_uri' => $this->api_url
			]);

			if(!$this->api_token){
				//recupera token si no lo tiene la config
				
				try{
	
					if($this->debug){
						Log::debug("Skoolpoint: Login user {$this->api_user}");
					}
					
					$response = $this->client->request('POST', "token", [
						'form_params' => [
							"username"=> $this->api_user,
							"password"=> $this->api_password,
						],
						'headers' => [
							'Accept'     => 'application/json'
						]
					]);
					if($this->debug) Log::debug("Skoolpoint: Login user RESPONSE:\n". $response->getBody() );
	
					$this->api_token = (string) $response->getBody();

					// dd($this->token);
				}catch(Exception $e){
					$this->parseException($e);
				}
				
			}

		
		}
	}
	

	protected function call($method, $url, $args=[]){
		$url=ltrim($url,"/");
		if(!$url) return false;

		$this->connect();
		
		//forzar header json
		if(isset($args["headers"])){
			$args["headers"]=array_merge($args["headers"],[
				'X-Auth' => $this->api_token,
				'Accept'     => 'application/json'
			]);
		}else{
			$args["headers"]=[
				'X-Auth' => $this->api_token,
				'Accept'     => 'application/json'
			];
		}


		
		if($this->debug){
			Log::debug("Skoolpoint: Calling $method to url:" .$this->api_url."".$url);
			Log::debug("Skoolpoint: Options:");
			Log::debug($args);
		}
		

	
		
		$ret=false;

		try{
			// dd($args);
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
			Log::error("Skoolpoint API error");
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
					throw new SkoolpointAuthException(__("Skoolpoint exception: The API key wasn't sent or is invalid")); break;
				
				default: break;
				
		   }
		}else{
			throw new SkoolpointConnectionException(__("Skoolpoint connection exception"));
				
		}
		
	}

}