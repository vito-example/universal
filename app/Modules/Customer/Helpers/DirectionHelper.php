<?php
/**
 *  app/Modules/Customer/Helpers/DirectionHelper.php
 *
 * Date-Time: 06.07.21
 * Time: 16:31
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Customer\Helpers;


/**
 * Class DirectionHelper
 * @package App\Modules\Customer\Helpers
 */
class DirectionHelper
{
    /**
     * @var string
     */
    private const DEFAULT_NAME = 'admin';

    /**
     * @var string
     */
    private const DEFAULT_MODULE = 'direction';

    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getRoutes(string $baseRouteName = self::DEFAULT_NAME, string $baseModuleName = self::DEFAULT_MODULE): array
    {
        $baseName = $baseRouteName . '.' . $baseModuleName . '.';
        return [
            'create' => route($baseName . 'create'),
            'create_data' => route($baseName . 'create_data'),
            'save' => route($baseName . 'store'),
            'edit' => route($baseName . 'edit', [])
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getLang(string $baseLangName = self::DEFAULT_NAME, string $baseModuleName = self::DEFAULT_MODULE): array
    {
        $baseFullLangName = $baseLangName . '.' . $baseModuleName . '.';

        $langData = [
            'menu' => __($baseFullLangName . 'menu'),
            'index' => __($baseFullLangName . 'index'),
            'create' => __($baseFullLangName . 'create'),
            'edit' => __($baseFullLangName . 'edit'),
            'actions' => __($baseFullLangName . 'actions'),
            'delete_title' => __($baseFullLangName . 'delete_title'),
            'update_successfully' => __($baseFullLangName . 'update_successfully'),
            'update_status_successfully' => __($baseFullLangName . 'update_status_successfully'),
            'save_successfully' => __($baseFullLangName . 'save_successfully'),
            'delete_successfully' => __($baseFullLangName . 'delete_successfully'),
            'save_text' => __($baseFullLangName . 'save_text'),
            'confirm_save' => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes' => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no' => __($baseFullLangName . 'confirm_save_no'),
            'status' => __($baseFullLangName . 'status'),
            'status_yes' => __($baseFullLangName . 'status_yes'),
            'status_no' => __($baseFullLangName . 'status_no'),
            'id' => __($baseFullLangName . 'id'),
            'title' => __($baseFullLangName . 'title'),
            'parent' => __($baseFullLangName . 'parent'),
            'no_one' => __($baseFullLangName . 'no_one'),
        ];

        foreach (config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }


    /**
     * @param array $directions
     *
     * @return array
     */
    public static function getDirectionRecursiveToArray(array $directions, int $without = 0): array
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($directions));
        $data = [];
        foreach ($iterator as $it) {
            if ($it === $without) continue;
            if (is_int($it)) {
                $data[]['value'] = $it;
                continue;
            }
            if (!isset($data[array_key_last($data)]['label'])) {
                $data[array_key_last($data)]['label'] = $it;
            }
        }

        return $data;
    }
}
