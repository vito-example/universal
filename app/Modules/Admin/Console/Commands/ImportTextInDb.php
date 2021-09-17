<?php


namespace App\Modules\Admin\Console\Commands;


use App\Console\Commands\Traits\Command as TraitCommand;
use App\Modules\Admin\Helper\FileHelper;
use App\Modules\Admin\Helper\ProfileHelper;
use App\Modules\Admin\Helper\RoleHelper;
use App\Modules\Admin\Helper\TextHelper;
use App\Modules\Admin\Helper\UserHelper;
use App\Modules\Admin\Models\Statics\Text;
use App\Modules\Admin\Repositories\Contracts\ITextRepository;
use App\Modules\Company\Helpers\CompanyActivityHelper;
use App\Modules\Company\Helpers\CompanyHelper;
use App\Modules\Customer\Helpers\ActivityHelper;
use App\Modules\Customer\Helpers\CitizenshipHelper;
use App\Modules\Customer\Helpers\CustomerHelper;
use App\Modules\Customer\Helpers\DoctorTypeHelper;
use App\Modules\Event\Helpers\EventHelper;
use App\Modules\Event\Helpers\EventLanguageHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use TextService;

class ImportTextInDb extends Command
{

    use TraitCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:text:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all translation texts in db and file.';

    /**
     * @var ITextRepository
     */
    protected $textRepository;

    /**
     * Create a new command instance.
     *
     * @param ITextRepository $textRepository
     */
    public function __construct(
        ITextRepository $textRepository
    )
    {
        parent::__construct();
        $this->textRepository = $textRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->titleMessage('Start import text in db and file');

        foreach(config('language_manager.locales') as $locale) {

            $this->titleMessage('Start locale ' . $locale);

            app()->setLocale($locale);

            $langTexts = array_merge(
                TextHelper::getLang(),
                RoleHelper::getLang(),
                ProfileHelper::getLang(),
                UserHelper::getLang(),
                FileHelper::getLang(),
                ActivityHelper::getLang(),
                CitizenshipHelper::getLang(),
                CustomerHelper::getLang(),
                EventHelper::getLang(),
                EventLanguageHelper::getLang(),
                CompanyHelper::getLang(),
                CompanyActivityHelper::getLang(),
                DoctorTypeHelper::getLang()
            );

            $this->saveTexts($langTexts,$locale);
            $this->configAttributes($locale);

//            foreach(PageModule::all() as $module) {
//                $langTexts = StaticPageHelper::getLang($module->key);
//                $this->saveTexts($langTexts, $locale);
//            }

            $this->titleMessage('End locale ' . $locale);
        }

        $this->titleMessage('End import text in db and file');
    }

    /**
     * @param $locale
     */
    public function configAttributes($locale)
    {
//        foreach(config('config_module.attributes') as $attribute) {
//            $this->saveValue($locale, $attribute['label'], 'admin');
//            if (!empty($attribute['options'])) {
//                foreach($attribute['options'] as $option) {
//                    $this->saveValue($locale, $option['label'], 'admin');
//                }
//            }
//        }
    }

    /**
     * @param $langTexts
     * @param $locale
     */
    public function saveTexts($langTexts, $locale)
    {
        foreach($langTexts as $langText) {

            $textArray = explode('.', $langText);
            $group = $textArray[0];
            $key =  implode('.', Arr::except($textArray, [0]));

            if( (strpos($langText, 'admin.') !== false ) ) {

                if (!Text::where('group', $group)->where('key', $key)->where('locale', $locale)->exists() ) {

                    $this->infoMessage('Import --group=' . $group . ' key=' . $key . ' locale=' . $locale);

                    $translation = Text::firstOrNew([
                        'locale' => $locale,
                        'group' => $group,
                        'key' => $key,
                    ]);
                    if (!$translation->value) {
                        $translation->value = $langText;
                    }
                    $translation->status = Text::STATUS_SAVED;
                    $translation->save();
                }
            }

            // Save in file.
            TextService::exportTranslations($group);
        }
    }

    /**
     * @param $string
     *
     * @return false|string
     */
    private function clearString($string)
    {
        return substr($string, 10,strlen($string));
    }

    /**
     * @param $locale
     * @param $key
     * @param string $group
     */
    private function saveValue($locale, $key, $group = 'attribute')
    {
        $translation = $this->textRepository->firstOrNew([
            'locale'    => $locale,
            'group'     => $group,
            'key'       => $key,
        ]);

        if (!$translation->value) {
            $translation->value = $key;
        }

        $translation->status = Text::STATUS_SAVED;
        $translation->save();
    }

}
