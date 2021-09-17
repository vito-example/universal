<?php

namespace App\Console;

use App\Modules\Admin\Console\Commands\ImportStubTexts;
use App\Modules\Admin\Console\Commands\ImportTextInDb;
use App\Modules\Admin\Console\Commands\ImportTexts;
use App\Utilities\ModuleHelper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    public function __construct(Application $app, Dispatcher $events)
    {
        parent::__construct($app, $events);
        // Order commands.
        if (ModuleHelper::isEnabled('admin')) {
            $orderCommands = [
                ImportTexts::class,
                ImportTextInDb::class,
                ImportStubTexts::class
            ];
            $this->commands = array_merge($this->commands, $orderCommands);
        }
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
