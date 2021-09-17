<?php


namespace App\Modules\Event\Providers;

use App\Modules\Base\Services\Admin\Image\GetImageWithType;
use App\Modules\Base\Services\Admin\Image\UploadImage;
use App\Modules\Base\Services\Admin\Translations\TranslationFieldsWithLocale;
use App\Modules\Event\Services\Event\StoreEventData;
use Illuminate\Support\ServiceProvider;

class EventModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register facades services.
     */
    public function register()
    {
        $this->app->bind('StoreEventData', function(){
            return new StoreEventData();
        });
    }

}
