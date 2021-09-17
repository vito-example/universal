<?php


namespace App\Modules\Pages\Facades\Services\Client;


use Illuminate\Support\Facades\Facade;

class PageSeoServiceFacade  extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PageSeoService';
    }
}
