<?php

namespace Common\Modules\Payments\Entity;

use Common\Modules\Entities\Engine\EnumValue;

/**
 * Class PaymentStatus
 * @package Common\Modules\Payments\Entity
 */
class PaymentStatus extends EnumValue
{

    /**
     * @var string
     */
    protected $defaultValue = 'pending';

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->getValue() == 'pending';
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->getValue() == 'success';
    }

    /**
     * @return bool
     */
    public function isFailure()
    {
        return $this->getValue() == 'failure';
    }

    /**
     * @param bool $lazyLoad
     * @return array
     */
    public function toArray($lazyLoad = true)
    {
        return parent::toArray() + array(
            'is_pending' => $this->isPending(),
            'is_success' => $this->isSuccess(),
            'is_failure' => $this->isFailure(),
        );
    }
}
