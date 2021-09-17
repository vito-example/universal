<?php


namespace App\Modules\Pages\Helpers;


class PageHelper
{

    /**
     * @param string $module
     *
     * @return array
     */
    public static function getRoutes(string $module = '') : array
    {
        $baseName = config('cms.admin.base_route_name') . '.page.';

        return [
            'create_data'       => route($baseName . 'create_data',$module),
            'save'              => route($baseName . 'store'),
            'edit'              => route($baseName . 'edit', [$module])
        ];
    }

    /**
     * @param string $module
     *
     * @return array
     */
    public static function getLang($module = '') : array
    {
        $baseFullLangName = 'admin.' . $module . '.';

        return [
            'menu'                          => __($baseFullLangName . 'menu'),
            'index'                         => __($baseFullLangName . 'index'),
            'create'                        => __($baseFullLangName . 'create'),
            'categories'                    => __($baseFullLangName . 'categories'),
            'edit'                          => __($baseFullLangName . 'edit'),
            'actions'                       => __($baseFullLangName . 'actions'),
            'delete_title'                  => __($baseFullLangName . 'delete_title'),
            'update_successfully'           => __($baseFullLangName . 'update_successfully'),
            'save_successfully'             => __($baseFullLangName . 'save_successfully'),
            'delete_successfully'           => __($baseFullLangName . 'delete_successfully'),
            'update_status_successfully'    => __($baseFullLangName . 'update_status_successfully'),
            'save_text'                     => __($baseFullLangName . 'save_text'),
            'confirm_save'                  => __($baseFullLangName . 'confirm_save'),
            'confirm_save_yes'              => __($baseFullLangName . 'confirm_save_yes'),
            'confirm_save_no'               => __($baseFullLangName . 'confirm_save_no'),
            'main_tab'                      => __($baseFullLangName . 'main_tab'),

            'feature_store'                 => __($baseFullLangName . 'feature_store'),
            'stories'                       => __($baseFullLangName . 'stories'),
            'last_stories_qty'              => __($baseFullLangName . 'last_stories_qty'),
            'last_videos_qty'               => __($baseFullLangName . 'last_videos_qty'),
            'special_project_cover'         => __($baseFullLangName . 'special_project_cover'),
            'video'                         => __($baseFullLangName . 'video'),
            'video_title'                   => __($baseFullLangName . 'video_title'),
            'video_sub_title'               => __($baseFullLangName . 'video_sub_title'),
            'video_url'                     => __($baseFullLangName . 'video_url'),

            'add_fields'                => __($baseFullLangName . 'add_fields'),
            'save_fields'               => __($baseFullLangName . 'save_fields'),
            'close_fields'              => __($baseFullLangName . 'close_fields'),
            'remove_field_confirm'      => __($baseFullLangName . 'remove_field_confirm'),
            'remove_field_confirm_yes'  => __($baseFullLangName . 'remove_field_confirm_yes'),
            'remove_field_confirm_no'   => __($baseFullLangName . 'remove_field_confirm_no'),

            'add_image'                 => __($baseFullLangName . 'add_image'),
            'save_image'                => __($baseFullLangName . 'save_image'),
            'close_image'               => __($baseFullLangName . 'close_image'),
            'remove_image_confirm'      => __($baseFullLangName . 'remove_image_confirm'),
            'remove_image_confirm_yes'  => __($baseFullLangName . 'remove_image_confirm_yes'),
            'remove_image_confirm_no'   => __($baseFullLangName . 'remove_image_confirm_no'),

            'remove_module_confirm'     => __($baseFullLangName . 'remove_module_confirm'),
            'remove_module_confirm_yes' => __($baseFullLangName . 'remove_module_confirm_yes'),
            'remove_module_confirm_no'  => __($baseFullLangName . 'remove_module_confirm_no'),
            'module_enable'             => __($baseFullLangName . 'module_enable'),
            'module_disable'            => __($baseFullLangName . 'module_disable'),
            'module_admin_title'        => __($baseFullLangName . 'module_admin_title'),

        ];
    }

}
