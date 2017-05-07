<?php

namespace Common\Modules\Payments\Entity;

use Common\Modules\Entities\Engine\Helper as CommonEntitiesHelper;
use Common\Modules\Entities\Engine\Entity;
use Common\Modules\Payments\Engine\Model;

/**
 * Class Method
 * @package Common\Modules\Payments\Entity
 */
class Method extends Entity
{

    /**
     * @var string
     */
    protected $_table = Model::TBL_METHODS;

    /**
     * @var string
     */
    protected $_query = Model::QRY_ENTITY_METHOD;

    /**
     * @var array
     */
    protected $_columns = array(
        'id',
        'name',
        'logo',
        'active',
        'installed_on',
    );

    protected $_relations = array();

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $logo;

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var string
     */
    protected $installedOn;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param string $format
     * @return bool|int|string
     */
    public function getInstalledOn($format = 'Y-m-d H:i:s')
    {
        return CommonEntitiesHelper::getDateTime($this->installedOn, $format);
    }

    /**
     * @param null $installedOn
     * @return $this
     */
    public function setInstalledOn($installedOn = null)
    {
        $this->installedOn = CommonEntitiesHelper::prepareDateTime($installedOn);

        return $this;
    }

    /**
     * @param $key
     * @return null
     */
    public function getVariable($key)
    {
        $columns = $this->toArray(false);

        return isset($columns[$key]) ? $columns[$key] : null;
    }
}
