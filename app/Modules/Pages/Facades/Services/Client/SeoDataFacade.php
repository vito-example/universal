<?php


namespace App\Modules\Pages\Facades\Services\Client;


use Illuminate\Support\Facades\Facade;

class SeoDataFacade  extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SeoData';
    }
}
