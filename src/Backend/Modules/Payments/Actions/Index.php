<?php

namespace Backend\Modules\Payments\Actions;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\DataGridDB as BackendDataGridDB;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Language as BL;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Payments\Engine\Model as BackendPaymentsModel;
use Common\Modules\Filter\Engine\Helper as CommonFilterHelper;
use Common\Modules\Filter\Engine\Filter;

/**
 * Class Index
 * @package Backend\Modules\Payments\Actions
 */
class Index extends BackendBaseActionIndex
{

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var BackendDataGridDB
     */
    private $dgPayments;

    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->loadFilter();
        $this->loadDataGrid();
        $this->parse();
        $this->display();
    }

    /**
     * Loads filter form
     */
    private function loadFilter()
    {
        $this->filter = new Filter();

        $this->filter
            ->addTextCriteria(
                'search',
                array('pr.display_name', 'pr.amount'),
                CommonFilterHelper::OPERATOR_PATTERN
            );
    }

    /**
     * @throws \Exception
     * @throws \SpoonDatagridException
     */
    private function loadDataGrid()
    {
        $this->dgPayments = new BackendDataGridDB($this->filter->getQuery(BackendPaymentsModel::QRY_DG_PAYMENTS));

        $this->dgPayments->setSortingColumns($this->dgPayments->getColumns());

        if (BackendAuthentication::isAllowedAction('Edit')) {
            $this->dgPayments->addColumn(
                'edit',
                null,
                BL::getLabel('Edit'),
                BackendModel::createURLForAction('Edit', null, null, null).'&amp;id=[id]',
                BL::getLabel('Edit')
            );
        }
    }

    /**
     * Parse all datagrids
     */
    protected function parse()
    {
        parent::parse();

        $this->filter->parse($this->tpl);

        $this->tpl->assign(
            'dgPayments',
            ($this->dgPayments->getNumResults() != 0) ? $this->dgPayments->getContent() : false
        );
    }
}
