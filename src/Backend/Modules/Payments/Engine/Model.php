<?php

namespace Backend\Modules\Payments\Engine;

use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Engine\Language as BL;
use Backend\Modules\Extensions\Engine\Model as BackendExtensionsModel;

/**
 * Class Model
 * @package Backend\Modules\Payments\Engine
 */
class Model
{

    /**
     *
     */
    const QRY_DG_PAYMENTS =
        'SELECT pa.id, pr.display_name, pa.status, pa.amount, pa.currency
        FROM payments AS pa
        LEFT JOIN profiles AS pr ON pr.id = pa.profile_id';

    /**
     * @param $method
     * @return bool
     */
    public static function existsMethod($method)
    {
        if (empty($method)) {
            return false;
        }

        return is_dir(BACKEND_MODULES_PATH.'/Payments/Methods/'.(string)$method);
    }

    /**
     * @param $method
     */
    public static function installMethod($method)
    {
        $class = 'Backend\\Modules\\Payments\\Methods\\'.$method.'\\Installer\\Installer';
        $variables = array();

        $installer = new $class(
            BackendModel::getContainer()->get('database'),
            BL::getActiveLanguages(),
            array_keys(BL::getInterfaceLanguages()),
            false,
            $variables
        );

        $installer->install();

        BackendExtensionsModel::clearCache();
    }

    /**
     * @param $method
     * @param $action
     * @param array $parameters
     * @return string
     * @throws \Exception
     */
    public static function createURLForMethodAction($method, $action, $parameters = array())
    {
        $parameters = array_merge(
            array('method' => $method, 'action' => $action),
            $parameters
        );

        return BackendModel::createURLForAction('Method', 'Payments', BL::getWorkingLanguage(), $parameters);
    }
}
