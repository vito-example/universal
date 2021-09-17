<?php


namespace App\Modules\Pages\Helpers;


class StaticPageHelper
{

    /**
     * @param string $module
     *
     * @return array
     */
    public static function getRoutes(string $module = '') : array
    {
        $baseName = config('cms.admin.base_route_name') . '.static_page.';

        return [
            'create'            => route($baseName . 'create',$module),
            'create_data'       => route($baseName . 'create_data',$module),
            'save'              => route($baseName . 'store',$module),
            'edit'              => route($baseName . 'edit', [$module]),
            'update_status'     => route($baseName . 'update_status',$module)
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
            'seo_tab'                       => __($baseFullLangName . 'seo_tab'),
            'category_tab'                       => __($baseFullLangName . 'category_tab'),
            'entity_attributes'             => __($baseFullLangName . 'entity_attributes'),

            //Field
            'id'                            => __($baseFullLangName . 'id'),
            'status'                        => __($baseFullLangName . 'status'),
            'status_yes'                    => __($baseFullLangName . 'status_yes'),
            'status_no'                     => __($baseFullLangName . 'status_no'),
            'title'                         => __($baseFullLangName . 'title'),
            'content'                       => __($baseFullLangName . 'content'),
            'cover_image'                   => __($baseFullLangName . 'cover_image'),
            'profile_image'                 => __($baseFullLangName . 'profile_image'),

        ];
    }

}
