<?php

if (! function_exists('mailrelay')) {
	function mailrelay($options=false){
		return new \Ajtarragona\MailRelay\MailRelayService($options);
	}
}
