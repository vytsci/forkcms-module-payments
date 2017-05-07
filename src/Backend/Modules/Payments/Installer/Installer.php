<?php

namespace Backend\Modules\Payments\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Class Installer
 * @package Backend\Modules\Payments\Installer
 */
class Installer extends ModuleInstaller
{

    /**
     *
     */
    public function install()
    {
        $this->importSQL(dirname(__FILE__).'/Data/install.sql');

        $this->addModule('Payments');

        $this->importLocale(dirname(__FILE__).'/Data/locale.xml');

        $this->setModuleRights(1, 'Payments');
        $this->setActionRights(1, 'Payments', 'Edit');
        $this->setActionRights(1, 'Payments', 'Index');
        $this->setActionRights(1, 'Payments', 'Method');
        $this->setActionRights(1, 'Payments', 'Methods');
        $this->setActionRights(1, 'Payments', 'Settings');

        $this->insertExtra('Payments', 'block', 'Payments', null, null, 'N', 700);

        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigationPaymentsId = $this->setNavigation($navigationModulesId, 'Payments');
        $this->setNavigation(
            $navigationPaymentsId,
            'Overview',
            'payments/index',
            array(
                'payments/edit',
            )
        );
        $this->setNavigation(
            $navigationPaymentsId,
            'Methods',
            'payments/methods',
            array(
                'payments/method',
            )
        );

        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, 'Payments', 'payments/settings');
    }
}
