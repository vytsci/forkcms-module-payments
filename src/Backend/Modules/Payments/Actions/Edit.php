<?php

namespace Backend\Modules\Payments\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;

use Backend\Modules\Payments\Engine\Helper as BackendPaymentsHelper;

use Common\Modules\Payments\Entity\Payment;

/**
 * Class Edit
 * @package Backend\Modules\Payments\Actions
 */
class Edit extends BackendBaseActionEdit
{

    /**
     * @var Payment
     */
    protected $payment;

    /**
     * Execute the action
     */
    public function execute()
    {
        $this->id = $this->getParameter('id', 'int');
        $this->payment = new Payment(array($this->id));

        if (!$this->payment->isLoaded()) {
            $this->redirect(BackendModel::createURLForAction('Index').'&error=non-existing');
        }

        $this->payment
            ->loadProfile()
            ->loadExternalInfo(BL::getWorkingLanguage());

        parent::execute();

        $this->parse();
        $this->display();
    }

    /**
     * Parse the page
     */
    protected function parse()
    {
        parent::parse();

        BackendPaymentsHelper::mapTemplateModifiers($this->tpl);

        $this->tpl->assign('payment', $this->payment->isLoaded() ? $this->payment->toArray() : array());
    }
}
