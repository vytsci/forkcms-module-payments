<?php

namespace Backend\Modules\Payments\Actions;

use Symfony\Component\Filesystem\Filesystem;

use Backend\Core\Engine\Base\ActionIndex as BackendBaseActionIndex;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Modules\Payments\Engine\Model as BackendPaymentsModel;

use Common\Modules\Payments\Entity\Method;


/**
 * Class InstallMethod
 * @package Backend\Modules\Payments\Actions
 */
class InstallMethod extends BackendBaseActionIndex
{
    /**
     * @var string
     */
    private $name;

    /**
     * @throws \Common\Exception\RedirectException
     * @throws \Exception
     */
    public function execute()
    {
        $this->name = $this->getParameter('name', 'string');

        if (BackendPaymentsModel::existsMethod($this->name)) {
            parent::execute();

            $this->validateInstall();

            BackendPaymentsModel::installMethod($this->name);

            $fs = new Filesystem();
            $fs->remove($this->getContainer()->getParameter('kernel.cache_dir'));

            $this->redirect(
                BackendModel::createURLForAction('Methods')
                .'&report=module-installed&var='.$this->name.'&highlight=row-module_'.$this->name
            );
        } else {
            $this->redirect(BackendModel::createURLForAction('Modules').'&error=non-existing');
        }
    }

    /**
     * @throws \Common\Exception\RedirectException
     * @throws \Exception
     */
    private function validateInstall()
    {
        if (BackendModel::isModuleInstalled($this->name)) {
            $this->redirect(
                BackendModel::createURLForAction('Methods').'&error=already-installed&var='.$this->name
            );
        }

        if (!is_file(BACKEND_MODULES_PATH.'/Payments/Methods/'.$this->name.'/Installer/Installer.php')) {
            $this->redirect(
                BackendModel::createURLForAction('Methods').'&error=no-installer-file&var='.$this->name
            );
        }
    }
}
