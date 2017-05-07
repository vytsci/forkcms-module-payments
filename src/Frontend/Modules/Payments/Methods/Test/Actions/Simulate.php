<?php

namespace Frontend\Modules\Payments\Methods\Test\Actions;

use Frontend\Modules\Payments\Engine\Base\MethodBlock as BaseMethodBlock;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Profiles\Engine\Authentication as FrontendProfilesAuthentication;

use Common\Modules\Currencies\Engine\Helper as CommonCurrenciesHelper;
use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;
use Common\Modules\Payments\Entity\Payment;

/**
 * Class Simulate
 * @package Frontend\Modules\Payments\Methods\Test\Actions
 */
class Simulate extends BaseMethodBlock
{

    /**
     * @var Payment
     */
    private $payment;

    /**
     *
     */
    public function execute()
    {
        if (!FrontendProfilesAuthentication::isLoggedIn()) {
            $this->redirect(
                FrontendNavigation::getURLForBlock(
                    'Profiles',
                    'Login'
                ).'?queryString='.urlencode($this->get('request')->getUri()),
                307
            );
        }

        $id = $this->getContainer()->get('request')->get('id');
        $this->payment = new Payment(array($id));

        if (
            !$this->payment->isLoaded()
            || !$this->payment->isPayer(FrontendProfilesAuthentication::getProfile())
        ) {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        $this->payment
            ->loadProfile()
            ->loadExternalInfo(FRONTEND_LANGUAGE)
            ->performSuccess(FRONTEND_LANGUAGE);

        $this->redirect(
            FrontendNavigation::getURLForBlock('Payments').'/'.$this->payment->getId()
        );
    }
}
