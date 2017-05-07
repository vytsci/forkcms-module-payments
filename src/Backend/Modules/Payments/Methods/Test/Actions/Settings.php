<?php

namespace Backend\Modules\Payments\Methods\Test\Actions;

use Backend\Modules\Payments\Engine\Base\MethodActionEdit;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Modules\Payments\Engine\Model as BackendPaymentsModel;
use Backend\Modules\Payments\Engine\Helper as BackendPaymentsHelper;

use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;
use Common\Modules\Payments\Engine\Helper as CommonPaymentsHelper;

/**
 * Class Settings
 * @package Backend\Modules\Payments\Methods\Test\Actions
 */
class Settings extends MethodActionEdit
{
    /**
     *
     */
    public function execute()
    {
        parent::execute();

        $this->loadForm();
        $this->validateForm();

        $this->parse();
        $this->display();
    }

    /**
     *
     */
    private function loadForm()
    {
        $this->frm = new BackendForm('settings');
    }

    /**
     * @throws \Common\Exception\RedirectException
     * @throws \Exception
     * @throws \SpoonFormException
     */
    private function validateForm()
    {
        if ($this->frm->isSubmitted()) {
            if ($this->frm->isCorrect()) {
                $this->redirect(
                    BackendPaymentsModel::createURLForMethodAction(
                        'test',
                        'settings',
                        array('report' => 'saved')
                    )
                );
            }
        }
    }

    /**
     * @throws \SpoonTemplateException
     */
    protected function parse()
    {
        parent::parse();

        $this->tpl->assign('method', $this->getMethod()->toArray());
    }
}
