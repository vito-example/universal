<?php


if (!function_exists('getPermissionKey')) {
    /**
     * @param $module
     * @param $type
     * @param bool $default
     * @return bool|\Illuminate\Config\Repository|mixed|null
     */
    function getPermissionKey($module, $type ,$default = true){

        if ($default) {
            return str_replace('{module_name}', $module, config('permission_list.' .$module. '.default.'.$type.'.key'));
        }

        return config('permission_list.' .$module. '.'.$type.'.key');
    }
}

if (!function_exists('getIdFromSlug')) {
    /**
     * @param null $slug
     *
     * @return int|string|null
     */
    function getIdFromSlug($slug = null){
        if (empty($slug)) {
            return null;
        }
        $slugSegments = explode('-',$slug);

        return !empty($slugSegments[0]) && is_numeric($slugSegments[0]) ? $slugSegments[0] : null;
    }
}

if (!function_exists('generateSlug')) {
    /**
     * @param $id
     * @param $title
     *
     * @return string
     */
    function generateSlug($id, $title){
        return $id . '-' . Str::slug($title);
    }
}

if (!function_exists('getModelName')) {
    /**
     * @param $model
     *
     * @return string
     */
    function getModelName($model){
        $className = get_class($model);
        return strtolower(class_basename($className));
    }
}

if (!function_exists('getSomeSegmentText')) {
    /**
     * @param $text
     * @param string $delimiter
     * @param int $segment
     *
     * @return mixed|string
     */
    function getSomeSegmentText($text, $delimiter = '.', $segment = 0){
        return explode($delimiter,$text)[$segment];
    }
}

if (!function_exists('convertCamelCaseToSnakeCase')) {
    /**
     * @param $input
     *
     * @return string
     */
    function convertCamelCaseToSnakeCase($input) {
        $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
        preg_match_all($pattern, $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ?
                strtolower($match) :
                lcfirst($match);
        }
        return implode('_', $ret);
    }
}
