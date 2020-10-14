<?php

namespace Ajtarragona\MailRelay\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Log;
use Exception;
use GuzzleHttp\Exception\ClientException;

trait IsRestClient
{
   
	private function call($method, $url, $args=[]){
		$url=ltrim($url,"/");
		if(!$url) return false;

		
		//forzar header json
		if(isset($args["headers"])){
			$args["headers"]=array_merge($args["headers"],[
				'X-AUTH-TOKEN' => $this->token,
				'Accept'     => 'application/json'
			]);
		}else{
			$args["headers"]=[
				'X-AUTH-TOKEN' => $this->token,
				'Accept'     => 'application/json'
			];
		}


		
		if($this->debug){
			Log::debug("MailRelay: Calling $method to url:" .$this->apiurl."".$url);
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
			
			dd($e);
			// $this->parseException($e);
		   
		}
		
	}
	

	private function parseException($e){
		if($this->debug){
			Log::error("MailRelay API error");
			Log::error($e->getMessage());
		}


		
	}

}