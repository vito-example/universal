<?php
/**
 *  app/Console/Commands/deletePage.php
 *
 * Date-Time: 10.08.21
 * Time: 11:54
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Console\Commands;

use App\Modules\Pages\Models\Page;
use Illuminate\Console\Command;

class deletePage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:page {page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete page';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $page = Page::where('name',$this->argument('page'))->first();
        if (!$page) {
            $this->info('Page not exist');
            return;
        }
        $page->delete();
        $this->info('Page delete successfully.');

    }
}
