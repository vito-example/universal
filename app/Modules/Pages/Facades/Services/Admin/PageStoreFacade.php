<?php


namespace App\Modules\Pages\Facades\Services\Admin;


use Illuminate\Support\Facades\Facade;

class PageStoreFacade  extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PageStore';
    }
}
