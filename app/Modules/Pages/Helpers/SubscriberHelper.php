<?php


namespace App\Modules\Pages\Helpers;


class SubscriberHelper
{

    /**
     * @param string $module
     *
     * @return array
     */
    public static function getLang($module = 'subscriber') : array
    {
        $baseFullLangName = 'admin.' . $module . '.';

        return [
            'menu'                          => __($baseFullLangName . 'menu'),
            'index'                         => __($baseFullLangName . 'index'),
            'export'                        => __($baseFullLangName . 'export'),
            'email'                         => __($baseFullLangName . 'email'),
            'fist_name'                     => __($baseFullLangName . 'fist_name'),
            'last_name'                     => __($baseFullLangName . 'last_name'),
            'is_subscribed'                 => __($baseFullLangName . 'is_subscribed'),
        ];
    }

}
