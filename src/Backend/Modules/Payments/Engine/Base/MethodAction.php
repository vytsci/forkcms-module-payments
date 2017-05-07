<?php

namespace Backend\Modules\Payments\Engine\Base;

use Symfony\Component\HttpKernel\KernelInterface;
use Backend\Core\Engine\Base\Action as BaseAction;
use Backend\Core\Engine\Language as BL;

use Common\Modules\Payments\Entity\Method;

/**
 * Class MethodAction
 * @package Backend\Modules\Payments\Engine\Base
 */
class MethodAction extends BaseAction
{

    /**
     * @var Method
     */
    protected $method;

    /**
     * @param KernelInterface $kernel
     * @param $method
     * @param $action
     * @throws \Backend\Core\Engine\Exception
     */
    public function __construct(KernelInterface $kernel, Method $method, $action)
    {
        parent::__construct($kernel);

        $this->setMethod($method);
        $this->setAction($action);
    }

    /**
     * @return string
     */
    protected function getBackendModulePath()
    {
        return BACKEND_MODULES_PATH.'/'.$this->URL->getModule().'/Methods/'.$this->getMethod()->getName();
    }

    /**
     * @param null $template
     * @throws \SpoonTemplateException
     */
    public function display($template = null)
    {
        // parse header
        $this->header->parse();

        /*
         * If no template is specified, we have to build the path ourself. The default template is
         * based on the name of the current action
         */
        if ($template === null) {
            $template = $this->getBackendModulePath().'/Layout/Templates/'.$this->getAction().'.tpl';
        }

        $this->content = $this->tpl->getContent($template);
    }

    /**
     * Execute the action
     */
    public function execute()
    {
        // add jquery, we will need this in every action, so add it globally
        $this->header->addJS('/bower_components/jquery/dist/jquery.min.js', 'Core', false, true);
        $this->header->addJS('/bower_components/jquery-migrate/jquery-migrate.min.js', 'Core', false, true);
        $this->header->addJS('/bower_components/jquery-ui/jquery-ui.min.js', 'Core', false, true);
        $this->header->addJS(
            '/bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js',
            'Core',
            false,
            true
        );
        $this->header->addJS('/bower_components/typeahead.js/dist/typeahead.bundle.min.js', 'Core', false, true);
        $this->header->addJS(
            '/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
            'Core',
            false,
            true
        );
        $this->header->addJS('jquery/jquery.backend.js', 'Core');

        // add items that always need to be loaded
        $this->header->addJS('utils.js', 'Core');
        $this->header->addJS('backend.js', 'Core');

        // add module js
        if (is_file($this->getBackendModulePath().'/Js/'.$this->getMethod()->getName().'.js')) {
            $this->header->addJS($this->getModule().'.js');
        }

        // add action js
        if (is_file($this->getBackendModulePath().'/Js/'.$this->getAction().'.js')) {
            $this->header->addJS($this->getAction().'.js');
        }

        // add core css files
        $this->header->addCSS('/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css', 'Core', true);
        $this->header->addCSS(
            '/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput-typeahead.css',
            'Core',
            true
        );
        $this->header->addCSS('screen.css', 'Core');
        $this->header->addCSS('debug.css', 'Core');

        // add module specific css
        if (is_file($this->getBackendModulePath().'/Layout/Css/'.$this->getMethod()->getName().'.css')) {
            $this->header->addCSS($this->getModule().'.css');
        }

        // store var so we don't have to call this function twice
        $var = array_map('strip_tags', $this->getParameter('var', 'array', array()));

        // is there a report to show?
        if ($this->getParameter('report') !== null) {
            // show the report
            $this->tpl->assign('report', true);

            // camelcase the string
            $messageName = strip_tags(\SpoonFilter::toCamelCase($this->getParameter('report'), '-'));

            // if we have data to use it will be passed as the var parameter
            if (!empty($var)) {
                $this->tpl->assign('reportMessage', vsprintf(BL::msg($messageName), $var));
            } else {
                $this->tpl->assign('reportMessage', BL::msg($messageName));
            }

            // highlight an element with the given id if needed
            if ($this->getParameter('highlight')) {
                $this->tpl->assign('highlight', strip_tags($this->getParameter('highlight')));
            }
        }

        // is there an error to show?
        if ($this->getParameter('error') !== null) {
            // camelcase the string
            $errorName = strip_tags(\SpoonFilter::toCamelCase($this->getParameter('error'), '-'));

            // if we have data to use it will be passed as the var parameter
            if (!empty($var)) {
                $this->tpl->assign('errorMessage', vsprintf(BL::err($errorName), $var));
            } else {
                $this->tpl->assign('errorMessage', BL::err($errorName));
            }
        }
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
