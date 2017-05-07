<?php

namespace Frontend\Modules\Payments\Engine\Base;

use Symfony\Component\HttpKernel\KernelInterface;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Core\Engine\Header;

use Common\Modules\Payments\Entity\Method;

/**
 * Class MethodWidget
 * @package Frontend\Modules\Payments\Engine\Base
 */
class MethodWidget extends FrontendBaseWidget
{

    /**
     * @var Method
     */
    protected $method;

    /**
     * MethodWidget constructor.
     * @param KernelInterface $kernel
     * @param Method $method
     * @param string $action
     * @param null $data
     */
    public function __construct(KernelInterface $kernel, Method $method, $action, $data = null)
    {
        parent::__construct($kernel, 'Payments', $action, $data);

        $this->setMethod($method);
    }

    /**
     * @param string $file
     * @param bool|false $overwritePath
     * @param bool|true $minify
     * @param null $addTimestamp
     */
    public function addCSS($file, $overwritePath = false, $minify = true, $addTimestamp = null)
    {
        // redefine
        $file = (string)$file;
        $overwritePath = (bool)$overwritePath;

        // use module path
        if (!$overwritePath) {
            $file = '/src/Frontend/Modules/Payments/Methods/'.$this->getMethod()->getName().'/Layout/Css/'.$file;
        }

        // add css to the header
        $this->header->addCSS($file, $minify, $addTimestamp);
    }

    /**
     * @param string $file
     * @param bool|false $overwritePath
     * @param bool|true $minify
     */
    public function addJS($file, $overwritePath = false, $minify = true)
    {
        $file = (string)$file;
        $overwritePath = (bool)$overwritePath;

        // use module path
        if (!$overwritePath) {
            $file = '/src/Frontend/Modules/Payments/Methods/'.$this->getMethod()->getName().'/Js/'.$file;
        }

        // add js to the header
        $this->header->addJS($file, $minify);
    }

    /**
     *
     */
    public function execute()
    {
        // build path to the module
        $frontendModulePath = FRONTEND_MODULES_PATH.'/Payments';
        $frontendMethodPath = FRONTEND_MODULES_PATH.'/Payments/Methods/'.$this->getMethod()->getName();

        // build URL to the module
        $frontendModuleURL = '/src/Frontend/Modules/Payments/Js';
        $frontendMethodURL = '/src/Frontend/Modules/Payments/Methods/'.$this->getMethod()->getName().'/Js';

        // add payments javascript file
        if (is_file($frontendModulePath.'/Js/Payments.js')) {
            $this->header->addJS(
                $frontendModuleURL.'/Payments.js',
                false,
                true,
                Header::PRIORITY_GROUP_MODULE
            );
        }

        // add methods javascript file
        if (is_file($frontendModulePath.'/Js/Methods.js')) {
            $this->header->addJS(
                $frontendModuleURL.'/Methods.js',
                false,
                true,
                Header::PRIORITY_GROUP_MODULE
            );
        }

        // add javascript file with same name as module (if the file exists)
        if (is_file($frontendMethodPath.'/Js/'.$this->getMethod()->getName().'.js')) {
            $this->header->addJS(
                $frontendMethodURL.'/'.$this->getMethod()->getName().'.js',
                false,
                true,
                Header::PRIORITY_GROUP_WIDGET
            );
        }

        // add javascript file with same name as the action (if the file exists)
        if (is_file($frontendMethodPath.'/Js/'.$this->getAction().'.js')) {
            $this->header->addJS(
                $frontendMethodURL.'/'.$this->getAction().'.js',
                false,
                true,
                Header::PRIORITY_GROUP_WIDGET
            );
        }
    }

    /**
     * @param null $path
     */
    protected function loadTemplate($path = null)
    {
        // no template given, so we should build the path
        if ($path === null) {
            // build path to the module
            $frontendModulePath = FRONTEND_MODULES_PATH.'/Payments/Methods/'.$this->getMethod()->getName();

            // build template path
            $path = $frontendModulePath.'/Layout/Widgets/'.$this->getAction().'.tpl';
        } else {
            // redefine
            $path = (string)$path;
        }

        // set template
        $this->setTemplatePath($path);
    }

    /**
     * @return Method
     */
    public function getMethod()
    {
        if ($this->method === null) {
            $this->method = new Method();
        }

        return $this->method;
    }

    /**
     * @param Method $method
     * @return $this
     */
    public function setMethod(Method $method)
    {
        $this->method = $method;

        return $this;
    }
}
