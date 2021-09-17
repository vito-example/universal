<?php


namespace App\Modules\Admin\Facades\Services\Admin;


use Illuminate\Support\Facades\Facade;

class TextServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TextService';
    }
}

