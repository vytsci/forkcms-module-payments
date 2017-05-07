<?php

namespace Frontend\Modules\Payments\Actions;

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Language as FL;
use Frontend\Core\Engine\Navigation as FrontendNavigation;

use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;

/**
 * Class Method
 * @package Frontend\Modules\Payments\Actions
 */
class Method extends FrontendBaseBlock
{

    /**
     *
     */
    public function execute()
    {
        $method = new \Common\Modules\Payments\Entity\Method(array($this->URL->getParameter(1)));
        $action = strtolower($this->URL->getParameter(2));

        if ($method === null && $action === null) {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        $actions = FL::getActions();
        $actionsKey = array_search($action, $actions);
        $action = $actionsKey ? $actionsKey : \SpoonFilter::toCamelCase($action, '-');

        $class = 'Frontend\\Modules\\Payments\\Methods\\'.$method->getName().'\\Actions\\'.$action;

        $object = new $class($this->getKernel(), $method, $action);
        $object->execute();
        $this->tpl = $object->getTemplate();
        $this->setTemplatePath($object->getTemplatePath());
    }
}
