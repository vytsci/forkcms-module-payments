<?php

namespace Frontend\Modules\Payments\Engine\Base;

use Symfony\Component\HttpKernel\KernelInterface;
use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Header;

use Common\Modules\Payments\Entity\Method;

/**
 * Class MethodBlock
 * @package Frontend\Modules\Payments\Engine\Base
 */
class MethodBlock extends FrontendBaseBlock
{

    /**
     * @var Method
     */
    protected $method;

    /**
     * @param KernelInterface $kernel
     * @param string $method
     * @param string $action
     * @param null $data
     */
    public function __construct(KernelInterface $kernel, Method $method, $action, $data = null)
    {
        parent::__construct($kernel, 'Payments', $action, $data);

        $this->setMethod($method);
    }

    /**
     * Add a CSS file into the array
     *
     * @param string $file The path for the CSS-file that should be loaded.
     * @param bool $overwritePath Whether or not to add the module to this path. Module path is added by default.
     * @param bool $minify Should the CSS be minified?
     * @param bool $addTimestamp May we add a timestamp for caching purposes?
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
     * Add a javascript file into the array
     *
     * @param string $file The path to the javascript-file that should be loaded.
     * @param bool $overwritePath Whether or not to add the module to this path. Module path is added by default.
     * @param bool $minify Should the file be minified?
     * @param bool $addTimestamp May we add a timestamp for caching purposes?
     */
    public function addJS(
        $file,
        $overwritePath = false,
        $minify = true,
        $addTimestamp = null,
        $priorityGroup = Header::PRIORITY_GROUP_DEFAULT
    ) {
        $file = (string)$file;
        $overwritePath = (bool)$overwritePath;

        // use module path
        if (!$overwritePath) {
            $file = '/src/Frontend/Modules/Payments/Methods/'.$this->getModule().'/Js/'.$file;
        }

        // add js to the header
        $this->header->addJS($file, $minify, $addTimestamp);
    }

    /**
     * Execute the action
     * If a javascript file with the name of the module or action exists it will be loaded.
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
        if (is_file($frontendMethodPath.'/Js/'.$this->getModule().'.js')) {
            $this->header->addJS(
                $frontendMethodURL.'/'.$this->getModule().'.js',
                false,
                true,
                Header::PRIORITY_GROUP_MODULE
            );
        }

        // add javascript file with same name as the action (if the file exists)
        if (is_file($frontendMethodPath.'/Js/'.$this->getAction().'.js')) {
            $this->header->addJS(
                $frontendMethodURL.'/'.$this->getAction().'.js',
                false,
                true,
                Header::PRIORITY_GROUP_MODULE
            );
        }
    }

    /**
     * Load the template
     *
     * @param string $path The path for the template to use.
     * @param bool $overwrite Should the template overwrite the default?
     */
    protected function loadTemplate($path = null, $overwrite = false)
    {
        $overwrite = (bool)$overwrite;

        // no template given, so we should build the path
        if ($path === null) {
            // build path to the module
            $frontendModulePath = FRONTEND_MODULES_PATH.'/Payments/Methods/'.$this->getMethod()->getName();

            // build template path
            $path = $frontendModulePath.'/Layout/Templates/'.$this->getAction().'.tpl';
        } else {
            // redefine
            $path = (string)$path;
        }

        // set properties
        $this->setOverwrite($overwrite);
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
