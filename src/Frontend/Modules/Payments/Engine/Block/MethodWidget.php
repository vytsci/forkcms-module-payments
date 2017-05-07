<?php

namespace Frontend\Modules\Payments\Engine\Block;

use Symfony\Component\HttpKernel\KernelInterface;
use Frontend\Core\Engine\Base\Config;
use Frontend\Core\Engine\Base\Object as FrontendBaseObject;
use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Core\Engine\Exception as FrontendException;

use Common\Modules\Payments\Entity\Method;

/**
 * Class MethodWidget
 * @package Frontend\Modules\Payments\Engine\Block
 */
class MethodWidget extends FrontendBaseObject
{
    /**
     * The current action
     *
     * @var string
     */
    private $action;

    /**
     * The config file
     *
     * @var    Config
     */
    private $config;

    /**
     * The data that was passed by the extra
     *
     * @var    mixed
     */
    private $data;

    /**
     * @var Method
     */
    private $method;

    /**
     * The extra object
     *
     * @var    FrontendBaseWidget
     */
    private $object;

    /**
     * The block's output
     *
     * @var    string
     */
    private $output;

    /**
     * @param KernelInterface $kernel
     * @param $method
     * @param $action
     * @param null $data
     * @throws FrontendException
     */
    public function __construct(KernelInterface $kernel, Method $method, $action, $data = null)
    {
        parent::__construct($kernel);

        // set properties
        $this->setMethod($method);
        $this->setAction($action);
        if ($data !== null) {
            $this->setData($data);
        }

        // load the config file for the required module
        $this->loadConfig();
    }

    /**
     * Execute the action
     * We will build the class name, require the class and call the execute method.
     */
    public function execute()
    {
        // build action-class-name
        $actionClass =
            'Frontend\\Modules\\Payments\\Methods\\'
            .$this->getMethod()->getName().'\\Widgets\\'.$this->getAction();

        // validate if class exists (aka has correct name)
        if (!class_exists($actionClass)) {
            throw new FrontendException(
                'The action file '.$actionClass.' could not be found.'
            );
        }
        // create action-object
        $this->object = new $actionClass($this->getKernel(), $this->getMethod(), $this->getAction(), $this->getData());

        // validate if the execute-method is callable
        if (!is_callable(array($this->object, 'execute'))) {
            throw new FrontendException(
                'The action file should contain a callable method "execute".'
            );
        }

        // call the execute method of the real action (defined in the module)
        $this->output = $this->object->execute();
    }

    /**
     * Get the current action
     * REMARK: You should not use this method from your code, but it has to be
     * public so we can access it later on in the core-code
     *
     * @return string
     */
    public function getAction()
    {
        // no action specified?
        if ($this->action === null) {
            $this->setAction($this->config->getDefaultAction());
        }

        // return action
        return $this->action;
    }

    /**
     * Get the block content
     *
     * @return string
     */
    public function getContent()
    {
        // set path to template if the widget didn't return any data
        if ($this->output === null) {
            return trim($this->object->getContent());
        }

        // return possible output
        return trim($this->output);
    }

    /**
     * Get the data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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
     * Get the assigned template.
     *
     * @return array
     */
    public function getTemplate()
    {
        return $this->object->getTemplate();
    }

    /**
     * Load the config file for the requested block.
     * In the config file we have to find disabled actions,
     * the constructor will read the folder and set possible actions
     * Other configurations will be stored in it also.
     */
    public function loadConfig()
    {
        $configClass = 'Frontend\\Modules\\Payments\\Methods\\'.$this->getMethod()->getName().'\\Config';

        // validate if class exists (aka has correct name)
        if (!class_exists($configClass)) {
            throw new FrontendException(
                'The config file '.$configClass.' could not be found.'
            );
        }

        // create config-object, the constructor will do some magic
        $this->config = new $configClass($this->getKernel(), 'Payments');
    }

    /**
     * Set the action
     *
     * @param string $action The action to load.
     */
    private function setAction($action = null)
    {
        if ($action !== null) {
            $this->action = (string)$action;
        }
    }

    /**
     * Set the data
     *
     * @param mixed $data The data that should be set.
     */
    private function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param Method $method
     */
    private function setMethod(Method $method)
    {
        $this->method = $method;
    }
}
