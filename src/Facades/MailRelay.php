<?php

namespace Ajtarragona\MailRelay\Facades; 

use Illuminate\Support\Facades\Facade;

class MailRelay extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'mailrelay';
    }
}
