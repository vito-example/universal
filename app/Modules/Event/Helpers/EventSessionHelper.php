<?php
/**
 *  app\Modules\Event\Helpers\EventSessionHelper.php
 *
 * Date-Time: 7/25/2021
 * Time: 1:02 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Event\Helpers;


class EventSessionHelper
{
    /**
     * @var string
     */
    private const DEFAULT_NAME = 'admin';

    /**
     * @var string
     */
    private const DEFAULT_MODULE = 'event_session';

    /**
     * @var string
     */
    private const NEW_MODULE = 'training_session';

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
            'edit' => route($baseName . 'edit', []),
            'update_status' => route($baseName . 'update_status'),
            'show' => route($baseName . 'show'),
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getLang(string $baseLangName = self::DEFAULT_NAME, string $baseModuleName = self::NEW_MODULE): array
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
            'main_tab' => __($baseFullLangName . 'main_tab'),
            //Options
            'start_date' => __($baseFullLangName . 'start_date'),
            'end_date' => __($baseFullLangName . 'end_date'),
            'timezone' => __($baseFullLangName . 'timezone'),
            'point' => __($baseFullLangName . 'point'),
            'close' => __($baseFullLangName . 'close'),
            'status_update_title' => __($baseFullLangName . 'status_update_title'),
            'sure_update_status_yes' => __($baseFullLangName . 'sure_update_status_yes'),
            'sure_update_status_no' => __($baseFullLangName . 'sure_update_status_no'),
            'sure_update_status' => __($baseFullLangName . 'sure_update_status'),
            'update_status_button' => __($baseFullLangName . 'update_status_button'),
            'date_from' => __($baseFullLangName . 'date_from'),
            'date_to' => __($baseFullLangName . 'date_to'),
            'search' => __($baseFullLangName . 'search'),
            'reset' => __($baseFullLangName . 'reset'),
            'close_fields' => __($baseFullLangName . 'close_fields'),
            'save_fields' => __($baseFullLangName . 'save_fields'),
            'add_element' => __($baseFullLangName . 'add_element'),
            'training_lecturers' => __($baseFullLangName . 'training_lecturers'),
            'please_input_start_date' => __($baseFullLangName . 'please_input_start_date'),
            'please_input_end_date' => __($baseFullLangName . 'please_input_end_date'),
            'start_date_more_than_end_date' => __($baseFullLangName . 'start_date_more_than_end_date'),
            'max_person' => __($baseFullLangName . 'max_person'),
            'enter_max_persons' => __($baseFullLangName . 'enter_max_persons'),
            'enter_start_date' => __($baseFullLangName . 'enter_start_date'),
            'enter_end_date' => __($baseFullLangName . 'enter_end_date'),
            'status_active' => __($baseFullLangName . 'status_active'),
            'status_completed' => __($baseFullLangName . 'status_completed'),
            'id' => __($baseFullLangName . 'id'),
            'register_persons' => __($baseFullLangName . 'register_persons'),
            'training' => __($baseFullLangName . 'training'),
            'training_title' => __($baseFullLangName . 'training_title'),
            'user_attendees' => __($baseFullLangName . 'user_attendees'),
            'employee_attendees' => __($baseFullLangName . 'employee_attendees'),
            'full_name' => __($baseFullLangName . 'full_name'),
            'email' => __($baseFullLangName . 'email'),
            'company' => __($baseFullLangName . 'company'),
            'show_profile' => __($baseFullLangName . 'show_profile'),
            'show' => __($baseFullLangName . 'show'),
            'phone' => __($baseFullLangName . 'phone'),
            'type' => __($baseFullLangName . 'type'),
            'type_planed' => __($baseFullLangName . 'type_planed'),
            'type_request' => __($baseFullLangName . 'type_request'),
            'attendees_list' => __($baseFullLangName . 'attendees_list'),
            'can_register_list' => __($baseFullLangName . 'can_register_list'),
            'users_can_registers' => __($baseFullLangName . 'users_can_registers'),
            'employees_can_registers' => __($baseFullLangName . 'employees_can_registers'),
            'addAttends' => __($baseFullLangName . 'addAttends'),
            'attendees' => __($baseFullLangName . 'attendees'),
            'price' => __($baseFullLangName . 'price'),
            'link' => __($baseFullLangName . 'link'),
        ];

        foreach (config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }

}
