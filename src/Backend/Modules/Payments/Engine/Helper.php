<?php

namespace Backend\Modules\Payments\Engine;

use Backend\Core\Engine\Language as BL;

/**
 * Class Helper
 * @package Backend\Modules\Payments\Engine
 */
class Helper
{

    /**
     * @param null $var
     * @param $value
     * @return mixed
     */
    public static function parseExtraFieldName($var = null, $value)
    {
        return BL::lbl('Payments'.\SpoonFilter::toCamelCase($value));
    }

    /**
     * @param null $var
     * @param $array
     * @param $key
     * @param string $default
     * @return string
     */
    public static function parseExtraFieldValue($var = null, $array, $key, $default = '')
    {
        return isset($array[$key]) && !empty($array[$key]['value']) ? $array[$key]['value'] : $default;
    }

    /**
     * @param \SpoonTemplate $tpl
     */
    public static function mapTemplateModifiers(\SpoonTemplate $tpl)
    {
        $tpl->mapModifier(
            'parseextrafieldname',
            array('Backend\\Modules\\Payments\\Engine\\Helper', 'parseExtraFieldName')
        );
        $tpl->mapModifier(
            'parseextrafieldvalue',
            array('Backend\\Modules\\Payments\\Engine\\Helper', 'parseExtraFieldValue')
        );
    }
}
