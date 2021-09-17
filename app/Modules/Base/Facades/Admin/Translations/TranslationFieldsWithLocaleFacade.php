<?php


namespace App\Modules\Base\Facades\Admin\Translations;


use Illuminate\Support\Facades\Facade;

class TranslationFieldsWithLocaleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TranslationFieldsWithLocale';
    }
}


