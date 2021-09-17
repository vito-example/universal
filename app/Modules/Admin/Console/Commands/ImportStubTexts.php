<?php

namespace App\Modules\Admin\Console\Commands;

use App\Modules\Admin\Models\Statics\Text;
use App\Modules\Admin\Repositories\Contracts\ITextRepository;
use App\Modules\Admin\Services\Admin\TextService;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * @property ITextRepository textRepository
 */
class ImportStubTexts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stub-text:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stub text import';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->files = new Filesystem();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $content = file_get_contents(base_path('resources/stubs/validation_text.stub'));

        foreach(config('language_manager.locales') as $locale) {

            try {
                $jsonContent = file_get_contents(base_path('resources/lang/'.$locale.'.json'));
            } catch (\Exception $ex) {
                $jsonContent = file_get_contents(base_path('resources/lang/en.json'));
            }


            $textData = json_decode($jsonContent,true);

            foreach($textData as $baseKey => $data) {
                $key = $baseKey;
                $value = $data;
                if (is_array($data)) {
                    foreach($data as $k => $dataText) {
                        Text::updateOrCreate([
                            'group'     => TextService::JSON_GROUP,
                            'key'       => $baseKey . '.' . $k,
                            'locale'    => $locale
                        ],[
                            'status'        => Text::STATUS_SAVED,
                            'value'         => $dataText
                        ]);
                    }
                    continue;
                }
                Text::updateOrCreate([
                    'group'     => TextService::JSON_GROUP,
                    'key'       => $key,
                    'locale'    => $locale
                ],[
                    'status'        => Text::STATUS_SAVED,
                    'value'         => $value
                ]);
            }

            $this->files->put(base_path('resources/lang/'.$locale.'/validation.php'), $content);
        }


    }

}
