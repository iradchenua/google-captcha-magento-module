<?php


namespace Ivan\DynamicShipping\Model\ResourceModel\Collection;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class DynamicCarrier extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(
            'Ivan\DynamicShipping\Model\DynamicCarrier',
            'Ivan\DynamicShipping\Model\ResourceModel\DynamicCarrier'
        );
    }
}