<?php


namespace App\Modules\Company\Facades\Services;


use Illuminate\Support\Facades\Facade;

class CompanyStoreFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CompanyStore';
    }
}


