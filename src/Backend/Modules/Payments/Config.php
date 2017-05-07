<?php

namespace Backend\Modules\Payments;

use Backend\Core\Engine\Base\Config as BackendBaseConfig;

/**
 * Class Config
 * @package Backend\Modules\Payments
 */
final class Config extends BackendBaseConfig
{

    /**
     * The default action
     *
     * @var    string
     */
    protected $defaultAction = 'Index';

    /**
     * The disabled actions
     *
     * @var    array
     */
    protected $disabledActions = array();

    /**
     * The disabled AJAX-actions
     *
     * @var    array
     */
    protected $disabledAJAXActions = array();
}
