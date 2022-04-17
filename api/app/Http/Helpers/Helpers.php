<?php

if (!function_exists('helperArraySearch')) {
    /**
     * Search in an array.
     * @param $arrObj array object
     * @param $property string
     * @param $needle string
     * @return array object
     */
    function helperArraySearch($arr, $property, $needle) {
        return array_filter(
            $arr,
            function ($e) use ($property, &$needle) {
                return $e[$property] == $needle;
            }
        );
    }
}

if (!function_exists('helperCustomMessages')) {
    /**
     * Get custom messages
     * @param $key
     * @param string $module
     * @return mixed
     */
    function helperCustomMessages($key, $module = '')
    {
        $module = (empty($module)) ? 'language' : $module;

        return trans()->get("custom/$module")[$key];
    }
}
