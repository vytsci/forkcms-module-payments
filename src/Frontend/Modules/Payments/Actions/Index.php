<?php

namespace Frontend\Modules\Payments\Actions;

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Profiles\Engine\Authentication as FrontendProfilesAuthentication;
use Frontend\Modules\Payments\Engine\Helper as FrontendPaymentsHelper;

use Common\Modules\Currencies\Engine\Helper as CommonCurrenciesHelper;
use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;
use Common\Modules\Payments\Entity\Payment;

/**
 * Class Index
 * @package Frontend\Modules\Payments\Actions
 */
class Index extends FrontendBaseBlock
{

    /**
     * @var Payment
     */
    private $payment;

    /**
     * @var array
     */
    private $methods;

    /**
     *
     */
    public function execute()
    {
        parent::execute();

        if (!FrontendProfilesAuthentication::isLoggedIn()) {
            $this->redirect(
                FrontendNavigation::getURLForBlock(
                    'Profiles',
                    'Login'
                ).'?queryString='.urlencode($this->get('request')->getUri()),
                307
            );
        }

        $this->loadTemplate();
        $this->getData();
        $this->loadAssets();
        $this->parse();
    }

    /**
     * Load the data, don't forget to validate the incoming data
     */
    private function getData()
    {
        $id = $this->URL->getParameter(0);
        $this->payment = new Payment(array($id));

        if (
            !$this->payment->isLoaded()
            || !$this->payment->isPayer(FrontendProfilesAuthentication::getProfile())
        ) {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        $this->payment
            ->loadProfile()
            ->loadExternalInfo(FRONTEND_LANGUAGE);

        $this->methods = CommonPaymentsModel::getListMethods();
    }

    /**
     *
     */
    private function loadAssets()
    {
        FrontendPaymentsHelper::loadAssets($this->header);
    }

    /**
     *
     */
    private function parse()
    {
        FrontendPaymentsHelper::parse($this->tpl);
        CommonCurrenciesHelper::parse($this->tpl);

        $this->tpl->mapModifier(
            'parsepaymentsmethodwidget',
            array('Frontend\\Modules\\Payments\\Engine\\Helper', 'parsePaymentsMethodWidget')
        );

        $this->tpl->assign('payment', $this->payment->toArray());
        $this->tpl->assign('methods', $this->methods);
    }
}
