<?php

namespace Common\Modules\Payments\Entity;

use Common\Modules\Entities\Engine\Helper as CommonEntitiesHelper;
use Common\Modules\Entities\Engine\Entity;
use Common\Modules\Payments\Engine\Model;

use Frontend\Modules\Profiles\Engine\Profile;

/**
 * Class Payment
 * @package Common\Modules\Payments\Entity
 */
class Payment extends Entity
{

    /**
     * @var string
     */
    protected $_table = Model::TBL_PAYMENTS;

    /**
     * @var string
     */
    protected $_query = Model::QRY_ENTITY_PAYMENT;

    /**
     * @var array
     */
    protected $_columns = array(
        'profile_id',
        'method_name',
        'status',
        'amount',
        'currency',
        'module',
        'external_id',
        'callback_info',
        'callback_success',
        'callback_failure',
        'created_on',
    );

    protected $_relations = array(
        'profile',
        'method',
        'title',
        'url',
        'extra_fields',
        'extra_values',
    );

    /**
     * @var
     */
    protected $profileId;

    /**
     * @var
     */
    protected $methodName;

    /**
     * @var PaymentStatus
     */
    protected $status;

    /**
     * @var
     */
    protected $amount;

    /**
     * @var
     */
    protected $currency;

    /**
     * @var
     */
    protected $module;

    /**
     * @var
     */
    protected $externalId;

    /**
     * @var
     */
    protected $callbackInfo;

    /**
     * @var
     */
    protected $callbackSuccess;

    /**
     * @var
     */
    protected $callbackFailure;

    /**
     * @var
     */
    protected $createdOn;

    /**
     * @var Profile
     */
    protected $profile;

    /**
     * @var Method
     */
    protected $method;

    /**
     * @var
     */
    protected $title;

    /**
     * @var
     */
    protected $url;

    /**
     * @var array
     */
    protected $extraFields = array();

    /**
     * @var array
     */
    protected $extraValues = array();

    /**
     * @return $this
     */
    public function loadProfile()
    {
        if ($this->isLoaded()) {
            $this->profile = new Profile($this->getProfileId());
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function loadMethod()
    {
        if ($this->isLoaded()) {
            $this->method = new Method($this->getMethodName());
        }

        return $this;
    }

    /**
     * @param $language
     * @return $this
     */
    public function loadExternalInfo($language)
    {
        if ($this->isLoaded()) {
            $class = '\\Frontend\\Modules\\'.$this->getModule().'\\Engine\\Model';
            $method = $this->getCallbackInfo();

            if (is_callable(array($class, $method))) {
                $call = $class.'::'.$method;

                $item = call_user_func($call, $this->getExternalId(), $language);

                if (isset($item['title'])) {
                    $this->setTitle($item['title']);
                    unset($item['title']);
                }

                if (isset($item['url'])) {
                    $this->setUrl($item['url']);
                    unset($item['url']);
                }

                if (!empty($item)) {
                    foreach ($item as $extraField => $extraValue) {
                        $this->addExtraValue($extraField, $extraValue);
                    }
                }
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * @param $profileId
     * @return $this
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param mixed $methodName
     * @return $this
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * @return PaymentStatus
     */
    public function getStatus()
    {
        if (is_null($this->status)) {
            $this->status = new PaymentStatus();
        }

        return $this->status;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = new PaymentStatus($status);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param $module
     * @return $this
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param $externalId
     * @return $this
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackInfo()
    {
        return $this->callbackInfo;
    }

    /**
     * @param $callbackInfo
     * @return $this
     */
    public function setCallbackInfo($callbackInfo)
    {
        $this->callbackInfo = $callbackInfo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackSuccess()
    {
        return $this->callbackSuccess;
    }

    /**
     * @param $callbackSuccess
     * @return $this
     */
    public function setCallbackSuccess($callbackSuccess)
    {
        $this->callbackSuccess = $callbackSuccess;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCallbackFailure()
    {
        return $this->callbackFailure;
    }

    /**
     * @param $callbackFailure
     * @return $this
     */
    public function setCallbackFailure($callbackFailure)
    {
        $this->callbackFailure = $callbackFailure;

        return $this;
    }

    /**
     * @param string $format
     * @return bool|int|string
     */
    public function getCreatedOn($format = 'Y-m-d H:i:s')
    {
        return CommonEntitiesHelper::getDateTime($this->createdOn, $format);
    }

    /**
     * @param null $createdOn
     * @return $this
     */
    public function setCreatedOn($createdOn = null)
    {
        $this->createdOn = CommonEntitiesHelper::prepareDateTime($createdOn);

        return $this;
    }

    /**
     * @param $profile
     * @return bool
     */
    public function isPayer($profile)
    {
        if (isset($profile)) {
            if ($profile instanceof \Frontend\Modules\Profiles\Engine\Profile) {
                return $this->getProfileId() == $profile->getId();
            }

            if (is_numeric($profile)) {
                return $this->getProfileId() == $profile;
            }
        }

        return false;
    }

    /**
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @return Method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param Method $method
     * @return $this
     */
    public function setMethod(Method $method)
    {
        $this->method = $method;
        $this->setMethodName($method->getName());

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtraFields()
    {
        return $this->extraFields;
    }

    /**
     * @return mixed
     */
    public function getExtraValues()
    {
        return $this->extraValues;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function addExtraValue($name, $value)
    {
        $this->extraValues[$name] = array('value' => $value);
        $this->extraFields[$name] = array('value' => $name);

        return $this;
    }

    /**
     * This method will save payment
     *
     * @param $language
     * @throws \Exception
     */
    public function performSuccess($language)
    {
        if (!$this->isLoaded()) {
            throw new \Exception('Cannot perform success while not loaded.');
        }

        $class = '\\Frontend\\Modules\\'.$this->getModule().'\\Engine\\Model';
        $method = $this->getCallbackSuccess();

        if (is_callable(array($class, $method))) {
            $call = $class.'::'.$method;
            call_user_func($call, $this->getExternalId(), $language);
        }

        $this
            ->setStatus('success')
            ->save();
    }

    /**
     * This method will save payment
     *
     * @param $language
     * @throws \Exception
     */
    public function performFailure($language)
    {
        if (!$this->isLoaded()) {
            throw new \Exception('Cannot perform failure while not loaded.');
        }

        $class = '\\Frontend\\Modules\\'.$this->getModule().'\\Engine\\Model';
        $method = $this->getCallbackFailure();

        if (is_callable(array($class, $method))) {
            $call = $class.'::'.$method;
            call_user_func($call, $this->getExternalId(), $language);
        }

        $this
            ->setStatus('failure')
            ->save();
    }
}
