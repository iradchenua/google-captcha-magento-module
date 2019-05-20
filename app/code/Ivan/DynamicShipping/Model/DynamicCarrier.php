<?php


namespace Ivan\DynamicShipping\Model;

use Magento\Framework\Model\AbstractModel;

class DynamicCarrier extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Ivan\DynamicShipping\Model\ResourceModel\DynamicCarrier::class);
    }
}