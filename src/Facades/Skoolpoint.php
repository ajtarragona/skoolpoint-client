<?php

namespace Ajtarragona\Skoolpoint\Facades; 

use Illuminate\Support\Facades\Facade;

class Skoolpoint extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'skoolpoint';
    }
}
