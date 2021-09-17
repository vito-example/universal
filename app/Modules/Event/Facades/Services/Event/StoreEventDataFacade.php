<?php


namespace App\Modules\Event\Facades\Services\Event;


use Illuminate\Support\Facades\Facade;

class StoreEventDataFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'StoreEventData';
    }
}


