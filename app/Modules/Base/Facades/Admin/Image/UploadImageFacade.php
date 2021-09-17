<?php


namespace App\Modules\Base\Facades\Admin\Image;


use Illuminate\Support\Facades\Facade;

class UploadImageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'UploadImage';
    }
}

