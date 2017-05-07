<?php

namespace Common\Modules\Payments\Engine;

/**
 * Class Helper
 * @package Common\Modules\Payments\Engine
 */
class Helper
{
    /**
     * @param $method
     * @param $name
     * @return string
     */
    public static function prepareMethodSettingName($method, $name)
    {
        return 'method_'.strtolower($method).'_'.$name;
    }
}
