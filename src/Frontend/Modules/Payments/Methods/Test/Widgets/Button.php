<?php

namespace Frontend\Modules\Payments\Methods\Test\Widgets;

use Frontend\Modules\Payments\Engine\Base\MethodWidget as BaseMethodWidget;

use Common\Modules\Payments\Entity\Payment;

/**
 * Class Button
 * @package Frontend\Modules\Payments\Methods\Test\Widgets
 */
class Button extends BaseMethodWidget
{

    /**
     * @var Payment
     */
    protected $payment;

    /**
     *
     */
    public function execute()
    {
        parent::execute();

        $this->loadPayment();
        $this->loadTemplate();
        $this->parse();
    }

    /**
     * @throws \Exception
     */
    protected function loadPayment()
    {
        if (isset($this->data['id'])) {
            $this->payment = new Payment(array($this->data['id']));
        }

        if (!$this->payment->isLoaded()) {
            throw new \Exception('Payment is required to proceed');
        }

        $this->payment
            ->loadProfile()
            ->loadExternalInfo(FRONTEND_LANGUAGE);
    }

    /**
     * @throws \SpoonTemplateException
     */
    private function parse()
    {
        $this->tpl->assign('payment', $this->payment->toArray());
    }
}
