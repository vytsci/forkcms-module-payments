<?php

namespace Backend\Modules\Payments\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Form as BackendForm;
use Backend\Core\Engine\Model as BackendModel;

/**
 * Class Settings
 * @package Backend\Modules\Payments\Actions
 */
class Settings extends BackendBaseActionEdit
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
                $this->redirect(BackendModel::createURLForAction('Settings').'&report=saved');
            }
        }
    }
}
