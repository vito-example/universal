<?php


namespace App\Modules\Base\Facades\Admin\Image;


use Illuminate\Support\Facades\Facade;

class GetImageWithTypeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'GetImageWithType';
    }
}


