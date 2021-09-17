<?php
/**
 *  app\Modules\Event\Helpers\EventSessionAttemptHelper.php
 *
 * Date-Time: 8/16/2021
 * Time: 9:26 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Event\Helpers;


class EventSessionAttemptHelper
{
    /**
     * @var string
     */
    private const DEFAULT_NAME = 'admin';

    /**
     * @var string
     */
    private const DEFAULT_MODULE = 'event_session_attempt';

    /**
     * @var string
     */
    private const NEW_MODULE = 'training_session_attempt';

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
            'actions' => __($baseFullLangName . 'actions'),
            'delete_title' => __($baseFullLangName . 'delete_title'),
            'delete_successfully' => __($baseFullLangName . 'delete_successfully'),
            //Field
            'user' => __($baseFullLangName . 'user'),
            'session' => __($baseFullLangName . 'session'),
            'person_total' => __($baseFullLangName . 'person_total'),
            'id' => __($baseFullLangName . 'id'),
            'created_at' => __($baseFullLangName . 'created_at'),
            'create_session' => __($baseFullLangName . 'create_session'),
            'max_person' => __($baseFullLangName . 'max_person'),
            'training' => __($baseFullLangName . 'training'),
            'training_title' => __($baseFullLangName . 'training_title'),
            'user_name' => __($baseFullLangName . 'user_name'),
            'date' => __($baseFullLangName . 'date'),
            'status_pending' => __($baseFullLangName . 'status_pending'),
            'type' => __($baseFullLangName . 'type'),
            'can_register_list' => __($baseFullLangName . 'can_register_list'),
            'price' => __($baseFullLangName . 'price'),
            'start_date' => __($baseFullLangName . 'start_date'),
            'end_date' => __($baseFullLangName . 'end_date'),
            'timezone' => __($baseFullLangName . 'timezone'),
            'save_successfully' => __($baseFullLangName . 'save_successfully'),
            'save_text' => __($baseFullLangName . 'save_text'),
            'status' => __($baseFullLangName . 'status'),
            'date_from' => __($baseFullLangName . 'date_from'),
            'date_to' => __($baseFullLangName . 'date_to'),
            'link' => __($baseFullLangName . 'link'),

        ];

        foreach (config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }

}
