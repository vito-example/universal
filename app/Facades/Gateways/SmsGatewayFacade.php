<?php


namespace App\Facades\Gateways;


use Illuminate\Support\Facades\Facade;

class SmsGatewayFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SmsGateway';
    }
}

