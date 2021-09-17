<?php

namespace App\Modules\Admin\Console\Commands;

use App\Modules\Admin\Repositories\Contracts\ITextRepository;
use Illuminate\Console\Command;
use TextService;

/**
 * @property ITextRepository textRepository
 */
class ImportTexts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all translation texts';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Import all translations
        TextService::importTranslations();
    }

}
