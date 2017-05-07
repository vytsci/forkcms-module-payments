<?php

namespace Backend\Modules\Payments\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Model as BackendModel;

use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;

/**
 * Class Method
 * @package Backend\Modules\Payments\Actions
 */
class Method extends BackendBaseActionEdit
{

    /**
     * @return mixed
     * @throws \Common\Exception\RedirectException
     * @throws \Exception
     */
    public function getContent()
    {
        $method = new \Common\Modules\Payments\Entity\Method(array($this->getParameter('method')));
        $action = \SpoonFilter::toCamelCase($this->getParameter('action'));

        if ($method === null && $action === null) {
            $this->redirect(BackendModel::createURLForAction('Methods').'&error=non-existing');
        }

        $class = 'Backend\\Modules\\Payments\\Methods\\'.$method->getName().'\\Actions\\'.$action;

        $object = new $class($this->getKernel(), $method, $action);
        $object->execute();

        return $object->getContent();
    }
}
