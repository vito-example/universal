<?php


namespace App\Modules\Event\Helpers;


class EventHelper
{
    /**
     * @var string
     */
    private const DEFAULT_NAME = 'admin';

    /**
     * @var string
     */
    private const DEFAULT_MODULE = 'event';

    /**
     * @var string
     */
    private const NEW_MODULE = 'training';

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
            'calendar' => route($baseName . 'calendar_data'),
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
            'id' => __($baseFullLangName . 'id'),
            'title' => __($baseFullLangName . 'title'),
            'description' => __($baseFullLangName . 'description'),
            'profile_image' => __($baseFullLangName . 'profile_image'),
            'options_tab' => __($baseFullLangName . 'options_tab'),
            'main_tab' => __($baseFullLangName . 'main_tab'),
            //Options
            'start_date' => __($baseFullLangName . 'start_date'),
            'end_date' => __($baseFullLangName . 'end_date'),
            'timezone' => __($baseFullLangName . 'timezone'),
            'event_url' => __($baseFullLangName . 'event_url'),
            'event_iframe' => __($baseFullLangName . 'event_iframe'),
            'event_language' => __($baseFullLangName . 'event_language'),
            'credit_point' => __($baseFullLangName . 'credit_point'),
            'point' => __($baseFullLangName . 'point'),
            'is_accredited' => __($baseFullLangName . 'is_accredited'),
            'is_accredited_yes' => __($baseFullLangName . 'is_accredited_yes'),
            'is_accredited_no' => __($baseFullLangName . 'is_accredited_no'),
            'event_price_option_free' => __($baseFullLangName . 'event_price_option_free'),
            'event_price_paid_for_all' => __($baseFullLangName . 'event_price_option_paid_for_all'),
            'event_price_paid_for_some_activities' => __($baseFullLangName . 'event_price_option_paid_for_some_activities'),
            'price_options' => __($baseFullLangName . 'price_options'),
            'price' => __($baseFullLangName . 'price'),
            'price_person_total' => __($baseFullLangName . 'price_person_total'),
            'add_price_activity' => __($baseFullLangName . 'add_price_activity'),
            'price_activities' => __($baseFullLangName . 'price_activities'),
            'activity' => __($baseFullLangName . 'activity'),
            'price_activities_action' => __($baseFullLangName . 'price_activities_action'),
            'credit_point_action' => __($baseFullLangName . 'credit_point_action'),
            'add_credit_point' => __($baseFullLangName . 'add_credit_point'),
            'currencies' => __($baseFullLangName . 'currencies'),
            'files' => __($baseFullLangName . 'files'),
            'credit_point_type' => __($baseFullLangName . 'credit_point_type'),
            'upload_file' => __($baseFullLangName . 'upload_file'),
            'upload_file_tooltip' => __($baseFullLangName . 'upload_file_tooltip'),
            'event_humans' => __($baseFullLangName . 'event_humans'),
            'lecturers' => __($baseFullLangName . 'lecturers'),
            'add_lecturers' => __($baseFullLangName . 'add_lecturers'),
            'lecturer_name' => __($baseFullLangName . 'lecturer_name'),
            'sponsors' => __($baseFullLangName . 'sponsors'),
            'add_sponsors' => __($baseFullLangName . 'add_sponsors'),
            'sponsor_name' => __($baseFullLangName . 'sponsor_name'),
            'speakers' => __($baseFullLangName . 'speakers'),
            'add_speakers' => __($baseFullLangName . 'add_speakers'),
            'speaker_name' => __($baseFullLangName . 'speaker_name'),
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
            'remove_field_confirm' => __($baseFullLangName . 'remove_field_confirm'),
            'remove_field_confirm_yes' => __($baseFullLangName . 'remove_field_confirm_yes'),
            'remove_field_confirm_no' => __($baseFullLangName . 'remove_field_confirm_no'),
            'question_user' => __($baseFullLangName . 'question_user'),
            'question_content' => __($baseFullLangName . 'question_content'),
            'question_created_at' => __($baseFullLangName . 'question_created_at'),
            'show_questions' => __($baseFullLangName . 'show_questions'),
            'banners' => __($baseFullLangName . 'banners'),
            'banners_tab' => __($baseFullLangName . 'banners_tab'),
            'register_qty' => __($baseFullLangName . 'register_qty'),
            'moderator' => __($baseFullLangName . 'moderator'),
            'attendee_user' => __($baseFullLangName . 'attendee_user'),
            'attendee_register_date' => __($baseFullLangName . 'attendee_register_date'),
            'calendar' => __($baseFullLangName . 'calendar'),
            'training_type' => __($baseFullLangName . 'training_type'),
            'type' => __($baseFullLangName . 'type'),
            'type_planed' => __($baseFullLangName . 'type_planed'),
            'type_request' => __($baseFullLangName . 'type_request'),
            'training_form' => __($baseFullLangName . 'training_form'),
            'form' => __($baseFullLangName . 'form'),
            'form_online' => __($baseFullLangName . 'form_online'),
            'form_offline' => __($baseFullLangName . 'form_offline'),
            'sessions' => __($baseFullLangName . 'sessions'),
            'event_sessions' => __($baseFullLangName . 'event_sessions'),
            'training_sessions' => __($baseFullLangName . 'training_sessions'),
            'training_directions' => __($baseFullLangName . 'training_directions'),
            'duration' => __($baseFullLangName . 'duration'),
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
            'can_register_list' => __($baseFullLangName . 'can_register_list'),
            'session_type' => __($baseFullLangName . 'session_type'),
            'please_select_lecturer' => __($baseFullLangName . 'please_select_lecturer'),
            'gallery_tab' => __($baseFullLangName . 'gallery_tab'),
            'galleries' => __($baseFullLangName . 'galleries'),
            'syllabus' => __($baseFullLangName . 'syllabus'),
            'place' => __($baseFullLangName . 'place'),
            'phone' => __($baseFullLangName . 'phone'),
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
