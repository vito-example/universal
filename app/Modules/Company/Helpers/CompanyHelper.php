<?php


namespace App\Modules\Company\Helpers;


class CompanyHelper
{
    /**
     * @param string $baseRouteName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getRoutes($baseRouteName = 'admin', $baseModuleName = 'company')
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
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'company')
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
            'main_tab' => __($baseFullLangName . 'main_tab'),
            'company_employees' => __($baseFullLangName . 'company_employees'),
            'confirm_save' => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes' => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no' => __($baseFullLangName . 'confirm_save_no'),
            //Field
            'id' => __($baseFullLangName . 'id'),
            'title' => __($baseFullLangName . 'title'),
            'identity_id' => __($baseFullLangName . 'identity_id'),
            'description' => __($baseFullLangName . 'description'),
            'company_owners' => __($baseFullLangName . 'company_owners'),
            'company_activities' => __($baseFullLangName . 'company_activities'),
            'profile_image' => __($baseFullLangName . 'profile_image'),
            'owner_name' => __($baseFullLangName . 'owner_name'),
            'activity_name' => __($baseFullLangName . 'activity_name'),
            'add_element' => __($baseFullLangName . 'add_element'),
            'full_name' => __($baseFullLangName . 'full_name'),
            'enter_full_name' => __($baseFullLangName . 'enter_full_name'),
            'email' => __($baseFullLangName . 'email'),
            'enter_email' => __($baseFullLangName . 'enter_email'),
            'phone' => __($baseFullLangName . 'phone'),
            'enter_phone' => __($baseFullLangName . 'enter_phone'),
            'role' => __($baseFullLangName . 'role'),
            'enter_role' => __($baseFullLangName . 'enter_role'),
            'specialty' => __($baseFullLangName . 'specialty'),
            'enter_specialty' => __($baseFullLangName . 'enter_specialty'),
            'save_fields' => __($baseFullLangName . 'save_fields'),
            'close_fields' => __($baseFullLangName . 'close_fields'),
            'please_input_full_name' => __($baseFullLangName . 'please_input_full_name'),
            'please_input_email' => __($baseFullLangName . 'please_input_email'),
            'please_input_valid_email' => __($baseFullLangName . 'please_input_valid_email'),
            'date_from' => __($baseFullLangName . 'date_from'),
            'date_to' => __($baseFullLangName . 'date_to'),
            'identify_id' => __($baseFullLangName . 'identify_id'),
            'address' => __($baseFullLangName . 'address'),
        ];

        foreach (config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }

}
