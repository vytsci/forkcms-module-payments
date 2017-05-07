<?php

namespace Frontend\Modules\Payments\Actions;

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Engine\Language as FL;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Profiles\Engine\Authentication as FrontendProfilesAuthentication;
use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;
use Common\Modules\Currencies\Engine\Helper as CommonCurrenciesHelper;

/**
 * Class Manage
 * @package Frontend\Modules\Payments\Actions
 */
class Manage extends FrontendBaseBlock
{

    /**
     * @var array
     */
    private $payments = array();

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
                ).'?queryString='.FrontendNavigation::getURLForBlock('Events', 'Manage'),
                307
            );
        }

        $this->loadData();

        $this->overrideHeader();
        $this->fillBreadcrumb();
        $this->loadTemplate();
        $this->parse();
    }

    /**
     *
     */
    private function loadData()
    {
        $this->payments = CommonPaymentsModel::getListPaymentsForManagement(
            FrontendProfilesAuthentication::getProfile()->getId(),
            FRONTEND_LANGUAGE
        );
    }

    /**
     *
     */
    private function overrideHeader()
    {
        $this->header->setPageTitle(ucfirst(FL::lbl('PaymentsManage')));
    }

    /**
     * @throws \Exception
     */
    private function fillBreadcrumb()
    {
        $this->breadcrumb->addElement(ucfirst(FL::lbl('PaymentsManage')));
    }

    /**
     *
     */
    protected function parse()
    {
        CommonCurrenciesHelper::parse($this->tpl);

        $this->tpl->assign('hideContentTitle', true);
        $this->tpl->assign('hideSidebars', true);

        $this->tpl->assign('payments', $this->payments);
    }
}
