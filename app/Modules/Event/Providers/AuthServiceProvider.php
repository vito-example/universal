<?php


namespace App\Modules\Event\Providers;

use App\Modules\Base\Services\Admin\Image\GetImageWithType;
use App\Modules\Base\Services\Admin\Image\UploadImage;
use App\Modules\Base\Services\Admin\Translations\TranslationFieldsWithLocale;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Policies\EventPolicy;
use App\Modules\Event\Services\Event\StoreEventData;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    protected $policies = [
        Event::class => EventPolicy::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }

    /**
     * Register facades services.
     */
    public function register()
    {
    }

}
