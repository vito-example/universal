<?php


namespace App\Modules\Customer\Helpers;


class ActivityHelper
{
    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'activity')
    {
        $baseName = $baseRouteName . '.' . $baseModuleName . '.';
        return [
            'create'            => route($baseName . 'create'),
            'create_data'       => route($baseName . 'create_data'),
            'save'              => route($baseName . 'store'),
            'edit'              => route($baseName . 'edit', []),
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'activity')
    {
        $baseFullLangName = $baseLangName . '.' . $baseModuleName . '.';

        $langData  = [
            'menu'                      => __($baseFullLangName . 'menu'),
            'index'                     => __($baseFullLangName . 'index'),
            'create'                    => __($baseFullLangName . 'create'),
            'edit'                      => __($baseFullLangName . 'edit'),
            'actions'                   => __($baseFullLangName . 'actions'),
            'delete_title'              => __($baseFullLangName . 'delete_title'),
            'update_successfully'       => __($baseFullLangName . 'update_successfully'),
            'update_status_successfully'       => __($baseFullLangName . 'update_status_successfully'),
            'save_successfully'         => __($baseFullLangName . 'save_successfully'),
            'delete_successfully'       => __($baseFullLangName . 'delete_successfully'),
            'save_text'                 => __($baseFullLangName . 'save_text'),
            'confirm_save'              => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes'          => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no'           => __($baseFullLangName . 'confirm_save_no'),
            //Field
            'status'                    => __($baseFullLangName . 'status'),
            'status_yes'                => __($baseFullLangName . 'status_yes'),
            'status_no'                 => __($baseFullLangName . 'status_no'),
            'id'                        => __($baseFullLangName . 'id'),
            'title'                     => __($baseFullLangName . 'title'),
        ];

        foreach(config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }

}
