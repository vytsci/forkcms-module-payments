<?php

namespace Common\Modules\Payments\Engine;

use Symfony\Component\Finder\Finder;

use Common\Core\Model as CommonModel;

use Common\Modules\Payments\Entity\Payment;
use Common\Modules\Payments\Entity\Method;

/**
 * Class Model
 * @package Common\Modules\Payments\Engine
 */
class Model
{

    /**
     *
     */
    const TBL_PAYMENTS = 'payments';

    /**
     *
     */
    const TBL_METHODS = 'payments_methods';

    /**
     *
     */
    const QRY_ENTITY_PAYMENT = 'SELECT pay.* FROM payments AS pay WHERE pay.id = ?';

    /**
     *
     */
    const QRY_ENTITY_METHOD = 'SELECT paym.* FROM payments_methods AS paym WHERE paym.name = ?';

    /**
     * @param $profileId
     * @param $language
     * @return array
     * @throws \SpoonDatabaseException
     */
    public static function getListPaymentsForManagement($profileId, $language)
    {
        $records = (array)CommonModel::getContainer()->get('database')->getRecords(
            'SELECT pay.* FROM '.self::TBL_PAYMENTS.' AS pay WHERE pay.profile_id = ?',
            array($profileId)
        );

        $result = array();
        foreach ($records as &$record) {
            $payment = new Payment();
            $payment
                ->assemble($record)
                ->loadExternalInfo($language);
            $result[$payment->getId()] = $payment->toArray();
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getListMethods()
    {
        $methods = self::getMethods();

        $result = array();
        foreach ($methods as $method) {
            $result[$method->getName()] = $method->toArray();
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getListMethodsOnFilesystem()
    {
        $return = array();
        $methods = (array)CommonModel::getContainer()->get('database')->getColumn(
            'SELECT paym.name FROM '.self::TBL_METHODS.' AS paym'
        );
        $finder = new Finder();
        foreach (
            $finder->directories()->in(PATH_WWW.'/src/Backend/Modules/Payments/Methods')->depth('==0') as $folder
        ) {
            if (!in_array($folder->getBasename(), $methods)) {
                $return[] = array('name' => $folder->getBasename());
            }
        }

        return $return;
    }

    /**
     * @return array
     * @throws \SpoonDatabaseException
     */
    public static function getMethods()
    {
        $records = (array)CommonModel::getContainer()->get('database')->getRecords(
            'SELECT paym.* FROM '.self::TBL_METHODS.' AS paym'
        );

        $result = array();
        foreach ($records as $record) {
            $method = new Method();
            $method->assemble($record);
            $result[$method->getName()] = $method;
        }

        return $result;
    }

    /**
     * @param $id
     * @return Method|null
     */
    public static function getMethod($id)
    {
        if ($id === null) {
            return null;
        }

        $methods = self::getMethods();

        return isset($methods[$id]) ? $methods[$id] : null;
    }
}
