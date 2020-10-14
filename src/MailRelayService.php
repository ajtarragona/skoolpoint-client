<?php

namespace Ajtarragona\MailRelay;

use Ajtarragona\MailRelay\Traits\IsRestClient;

class MailRelayService
{

    use IsRestClient;


	protected $options;
	protected $apiurl;
	protected $client;
	protected $token;
	


	public function __construct($options=array()) { 
		$opts=config('mailrelay');
		if($options) $opts=array_merge($opts,$options);
		$this->options= json_decode(json_encode($opts), FALSE);
        
		$this->debug = $this->options->debug;
		$this->apiurl = rtrim($this->options->api_url,"/")."/"; //le quito la barra final si la tiene y se la vuelvo a poner. Asi me aseguro que siempre acaba en barra.
		$this->token = $this->options->api_token;
        
	}



	public function senders(){
		$ret=$this->call('GET','senders');
		dd($ret);
	}
}