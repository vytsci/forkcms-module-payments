<?php

namespace Frontend\Modules\Payments\Engine;

use Common\Core\Model as CommonModel;

use Frontend\Core\Engine\Header;
use Frontend\Modules\Payments\Engine\Block\MethodWidget as BlockMethodWidget;

use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;
use Common\Modules\Payments\Entity\Method;

/**
 * Class Helper
 * @package Frontend\Modules\Payments\Engine
 */
class Helper
{
    /**
     * @param \SpoonTemplate $tpl
     */
    public static function parse(\SpoonTemplate $tpl)
    {
        $tpl->mapModifier(
            'parsepaymentsmethodwidget',
            array('Frontend\\Modules\\Payments\\Engine\\Helper', 'parsePaymentsMethodWidget')
        );
    }

    /**
     * @param $var
     * @param $method
     * @param $action
     * @param null $id
     * @return null|string
     * @throws \Exception
     */
    public static function parsePaymentsMethodWidget($var, $method, $action, $id = null)
    {
        $method = new Method($method);
        $action = \SpoonFilter::toCamelCase($action);

        $data = $id !== null ? serialize(array('id' => $id)) : null;
        $extra = new BlockMethodWidget(CommonModel::get('kernel'), $method, $action, $data);
        CommonModel::getContainer()->set('parsePaymentsMethodWidget', true);

        try {
            $extra->execute();
            $content = $extra->getContent();
            CommonModel::getContainer()->set('parsePaymentsMethodWidget', null);

            return $content;
        } catch (\Exception $e) {
            if (CommonModel::getContainer()->getParameter('kernel.debug')) {
                throw $e;
            }

            return null;
        }
    }

    /**
     * @param Header $header
     */
    public static function loadAssets(Header $header)
    {
        $methods = CommonPaymentsModel::getMethods();

        foreach ($methods as $method) {
            $frontendMethodPath = FRONTEND_MODULES_PATH.'/Payments/Methods/'.$method->getName();
            $frontendMethodURL = '/src/Frontend/Modules/Payments/Methods/'.$method->getName();

            if (is_file($frontendMethodPath.'/Layout/Css/'.$method->getName().'.css')) {
                $header->addCSS($frontendMethodURL.'/Layout/Css/'.$method->getName().'.css');
            }

            if (is_file($frontendMethodPath.'/Layout/Css/Button.css')) {
                $header->addCSS($frontendMethodURL.'/Layout/Css/Button.css');
            }

            if (is_file($frontendMethodPath.'/Js/'.$method->getName().'.js')) {
                $header->addJS(
                    $frontendMethodURL.'/Js/'.$method->getName().'.js',
                    false,
                    true,
                    Header::PRIORITY_GROUP_WIDGET
                );
            }

            if (is_file($frontendMethodPath.'/Js/Button.js')) {
                $header->addJS(
                    $frontendMethodURL.'/Js/Button.js',
                    false,
                    true,
                    Header::PRIORITY_GROUP_WIDGET
                );
            }
        }

        $header->addJS(
            'https://mistertango.com/resources/scripts/mt.collect.js',
            false,
            true,
            Header::PRIORITY_GROUP_GLOBAL
        );
    }
}
