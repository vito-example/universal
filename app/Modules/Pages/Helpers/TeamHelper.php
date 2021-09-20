<?php
/**
 *  app\Modules\Pages\Helpers\TeamHelper.php
 *
 * Date-Time: 9/19/2021
 * Time: 4:59 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Pages\Helpers;


class TeamHelper
{
    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'team')
    {
        $baseName = $baseRouteName . '.' . $baseModuleName . '.';
        return [
            'create' => route($baseName . 'create'),
            'create_data' => route($baseName . 'create_data'),
            'save' => route($baseName . 'store'),
            'edit' => route($baseName . 'edit', []),
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'blog')
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
            //Field
            'status' => __($baseFullLangName . 'status'),
            'status_yes' => __($baseFullLangName . 'status_yes'),
            'status_no' => __($baseFullLangName . 'status_no'),
            'id' => __($baseFullLangName . 'id'),
            'name' => __($baseFullLangName . 'name'),
            'about' => __($baseFullLangName . 'about'),
            'position' => __($baseFullLangName . 'position'),
            'image_profile' => __($baseFullLangName . 'image_profile'),
            'close_fields' => __($baseFullLangName . 'close_fields'),
            'save_fields' => __($baseFullLangName . 'save_fields'),
            'main_tab' => __($baseFullLangName . 'main_tab'),
            'seo_tab' => __($baseFullLangName . 'seo_tab'),
            'meta_title' => __($baseFullLangName . 'meta_title'),
            'meta_description' => __($baseFullLangName . 'meta_description'),
            'meta_keyword' => __($baseFullLangName . 'meta_keyword'),
        ];

        foreach (config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }

}
