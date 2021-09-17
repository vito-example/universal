<?php


namespace App\Modules\Base\Providers;

use App\Modules\Base\Services\Admin\Category\SaveCategory;
use App\Modules\Base\Services\Admin\Image\GetImageWithType;
use App\Modules\Base\Services\Admin\Image\UploadImage;
use App\Modules\Base\Services\Admin\Seo\StoreSeo;
use App\Modules\Base\Services\Admin\Slug\StoreSlug;
use App\Modules\Base\Services\Admin\Tag\StoreTag;
use App\Modules\Base\Services\Admin\Tag\TagData;
use App\Modules\Base\Services\Admin\Translations\TranslationFieldsWithLocale;
use Illuminate\Support\ServiceProvider;

class BaseModuleServiceProvider extends ServiceProvider
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
        $this->app->bind('UploadImage', function(){
            return new UploadImage();
        });
        $this->app->bind('GetImageWithType', function(){
            return new GetImageWithType();
        });
        $this->app->bind('TranslationFieldsWithLocale', function(){
            return new TranslationFieldsWithLocale();
        });
    }

}
