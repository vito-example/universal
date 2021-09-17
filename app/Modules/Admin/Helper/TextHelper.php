<?php


namespace App\Modules\Admin\Helper;


class TextHelper
{

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     * @return array
     */
    public static function getLang($baseLangName = 'admin', $baseModuleName = 'text')
    {

        $baseFullLangName = $baseLangName . '.' . $baseModuleName . '.';

        return [
            'menu'                      => __($baseFullLangName . 'menu'),
            'index'                     => __($baseFullLangName . 'index'),
            'create'                    => __($baseFullLangName . 'create'),
            'key'                       => __($baseFullLangName . 'key'),
            'file_name'                 => __($baseFullLangName . 'file_name'),
            'actions'                   => __($baseFullLangName . 'actions'),
            'edit_title'                => __($baseFullLangName . 'edit_title'),
            'delete_title'              => __($baseFullLangName . 'delete_title'),
            'update_successfully'       => __($baseFullLangName . 'update_successfully'),
            'save_successfully'         => __($baseFullLangName . 'save_successfully'),
            'delete_successfully'       => __($baseFullLangName . 'delete_successfully'),
            'import_successfully'       => __($baseFullLangName . 'import_successfully'),
            'save_text'                 => __($baseFullLangName . 'save_text'),
            'cancel_text'               => __($baseFullLangName . 'cancel_text'),
            'delete_confirm'            => __($baseFullLangName . 'delete_confirm'),
            'delete_confirm_yes'        => __($baseFullLangName . 'delete_confirm_yes'),
            'delete_confirm_no'         => __($baseFullLangName . 'delete_confirm_no'),
            'update_all'                => __($baseFullLangName . 'update_all'),
            'export'                    => __($baseFullLangName . 'export'),
            'filter_key'                => __($baseFullLangName . 'filter_key'),
            'import'                    => __($baseFullLangName . 'import'),
            'import_title'              => __($baseFullLangName . 'import_title'),
            'import_file'               => __($baseFullLangName . 'import_file'),
            'cancel_import_file'        => __($baseFullLangName . 'cancel_import_file'),
            'upload_import_file'        => __($baseFullLangName . 'upload_import_file'),

        ];

    }

}
