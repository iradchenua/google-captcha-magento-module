<?php


namespace Ivan\DynamicShipping\Plugin;

class CarrierFactoryUpdater
{
    public function afterGet(\Magento\Shipping\Model\CarrierFactory $subject, $result, $carrierCode)
     {
        if (preg_match('/^dynamic_/', $carrierCode)) {
             $result->setCode($carrierCode);
         }
        return $result;
    }
    public function afterCreate(\Magento\Shipping\Model\CarrierFactory $subject, $result, $carrierCode, $storeId = null)
    {
        if (preg_match('/^dynamic_/', $carrierCode)) {
            $result->setCode($carrierCode);
        }
        return $result;
    }
}