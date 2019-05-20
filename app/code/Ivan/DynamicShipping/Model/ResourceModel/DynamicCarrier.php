<?php


namespace Ivan\DynamicShipping\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class DynamicCarrier extends AbstractDb
{
    public function _construct()
    {
        $this->_init(
            'ivan_dynamicshipping_carrier',
            'dynamicshipping_id'
        );
    }
}