<?php
/**
 *  app/Modules/Company/Helpers/CompanyEmployeeHelper.php
 *
 * Date-Time: 22.07.21
 * Time: 09:41
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Company\Helpers;

/**
 * Class CompanyEmployeeHelper
 * @package App\Modules\Company\Helpers
 */
class CompanyEmployeeHelper
{

    /**
     * @var string
     */
    private const DEFAULT_NAME = 'admin';

    /**
     * @var string
     */
    private const DEFAULT_MODULE = 'company_employee';

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
        ];
    }

    /**
     * @param string $baseLangName
     * @param string $baseModuleName
     *
     * @return array
     */
    public static function getLang(string $baseLangName = self::DEFAULT_NAME, string $baseModuleName = self::DEFAULT_MODULE): array
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
            'name' => __($baseFullLangName . 'name'),
            'email' => __($baseFullLangName . 'email'),
            'phone' => __($baseFullLangName . 'phone'),
            'role' => __($baseFullLangName . 'role'),
            'specialty' => __($baseFullLangName . 'specialty'),
            'id' => __($baseFullLangName . 'id'),
            'title' => __($baseFullLangName . 'title'),
            'companies' => __($baseFullLangName . 'companies'),
            'company' => __($baseFullLangName . 'company'),
            'export' => __($baseFullLangName . 'export'),
        ];

        foreach (config('language_manager.locales') as $locale) {
            $langData[$locale] = __($baseLangName . '.' . $locale);
        }

        return $langData;
    }

}
