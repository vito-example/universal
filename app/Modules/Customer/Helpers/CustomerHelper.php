<?php


namespace App\Modules\Customer\Helpers;


class CustomerHelper
{
    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'customer')
    {
        $baseName = $baseRouteName . '.' . $baseModuleName . '.';
        return [
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
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'customer')
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
            'title' => __($baseFullLangName . 'title'),
            'verifies' => __($baseFullLangName . 'verifies'),
            'name' => __($baseFullLangName . 'name'),
            'surname' => __($baseFullLangName . 'surname'),
            'personal_number' => __($baseFullLangName . 'personal_number'),
            'passport_number' => __($baseFullLangName . 'passport_number'),
            'phone_number' => __($baseFullLangName . 'phone_number'),
            'activity_id' => __($baseFullLangName . 'activity_id'),
            'register_date_from' => __($baseFullLangName . 'register_date_from'),
            'advertisement' => __($baseFullLangName . 'advertisement'),
            'activity_verify_id' => __($baseFullLangName . 'activity_verify_id'),
            'register_date_to' => __($baseFullLangName . 'register_date_to'),
            'export' => __($baseFullLangName . 'export'),
            'show_profile' => __($baseFullLangName . 'show_profile'),
            'profile_photo_path' => __($baseFullLangName . 'profile_photo_path'),
            'events' => __($baseFullLangName . 'events'),
            'event_id' => __($baseFullLangName . 'event_id'),
            'event_title' => __($baseFullLangName . 'event_title'),
            'event_start_date' => __($baseFullLangName . 'event_start_date'),
            'companies' => __($baseFullLangName . 'companies'),
            'company_title' => __($baseFullLangName . 'company_title'),
            'doctor_types' => __($baseFullLangName . 'doctor_types'),
            'citizenship' => __($baseFullLangName . 'citizenship'),
            'password' => __($baseFullLangName . 'password'),
            'email' => __($baseFullLangName . 'email'),
        ];

        foreach (config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }

}
