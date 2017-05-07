<?php

namespace Backend\Modules\Payments\Actions;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\DataGridArray as BackendDataGridArray;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Common\Modules\Payments\Engine\Model as CommonPaymentsModel;

/**
 * Class Methods
 * @package Backend\Modules\Payments\Actions
 */
class Methods extends BackendBaseActionIndex
{

    /**
     * @var BackendDataGridArray
     */
    private $dgMethodsInstalled;

    /**
     * @var BackendDataGridArray
     */
    private $dgMethodsNotInstalled;

    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->loadInstalled();
        $this->loadNotInstalled();
        $this->parse();
        $this->display();
    }

    /**
     * @throws \Exception
     * @throws \SpoonDatagridException
     */
    private function loadInstalled()
    {
        $this->dgMethodsInstalled = new BackendDataGridArray(CommonPaymentsModel::getListMethods());

        $this->dgMethodsInstalled->setSortingColumns($this->dgMethodsInstalled->getColumns());

        if (BackendAuthentication::isAllowedAction('Method')) {
            $this->dgMethodsInstalled->addColumn(
                'edit',
                null,
                BL::getLabel('Settings'),
                BackendModel::createURLForAction(
                    'Method',
                    null,
                    null,
                    array('method' => '[name]', 'action' => 'settings'),
                    false
                ),
                BL::getLabel('Settings')
            );
        }
    }

    /**
     * @throws \Exception
     * @throws \SpoonDatagridException
     */
    private function loadNotInstalled()
    {
        $this->dgMethodsNotInstalled = new BackendDataGridArray(CommonPaymentsModel::getListMethodsOnFilesystem());

        if (BackendAuthentication::isAllowedAction('Method')) {
            $this->dgMethodsNotInstalled->addColumn(
                'install',
                null,
                BL::getLabel('Install'),
                BackendModel::createURLForAction(
                    'InstallMethod',
                    null,
                    null,
                    array('name' => '[name]'),
                    false
                ),
                BL::getLabel('Install')
            );
        }
    }

    /**
     * Parse all datagrids
     */
    protected function parse()
    {
        parent::parse();

        $this->tpl->assign(
            'dgMethodsInstalled',
            ($this->dgMethodsInstalled->getNumResults() != 0) ? $this->dgMethodsInstalled->getContent() : false
        );

        $this->tpl->assign(
            'dgMethodsNotInstalled',
            ($this->dgMethodsNotInstalled->getNumResults() != 0) ? $this->dgMethodsNotInstalled->getContent() : false
        );
    }

    /**
     * @param $installedOn
     * @return string
     * @throws \Exception
     */
    public function prepareInstallButton($installedOn)
    {
        $result = $installedOn;

        if (empty($result)) {
            $result = BackendModel::createURLForAction(
                'InstallMethod',
                null,
                null,
                array('name' => '[name]'),
                false
            );
        }

        return $result;
    }
}
