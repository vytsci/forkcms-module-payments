<?php

namespace Backend\Modules\Payments\Methods\Test\Installer;

use Backend\Modules\Payments\Installer\MethodInstaller;

/**
 * Class Installer
 * @package Backend\Modules\Payments\Methods\Test\Installer
 */
class Installer extends MethodInstaller
{
    /**
     *
     */
    public function install()
    {
        $this->importSQL(dirname(__FILE__).'/Data/install.sql');

        $this->addMethod('Test');

        $this->importLocale(dirname(__FILE__).'/Data/locale.xml');
    }
}
