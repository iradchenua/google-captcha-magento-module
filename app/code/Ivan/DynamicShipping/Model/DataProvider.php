<?php


namespace Ivan\DynamicShipping\Model;

use Magento\Framework\Exception\NoSuchEntityException;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    private $request;

    public function __construct(
        \Ivan\DynamicShipping\Model\ResourceModel\Collection\DynamicCarrier $collection,
        \Magento\Framework\App\RequestInterface $request,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $data = [],
        array $meta = []
    ) {
        $this->request = $request;
        $this->collection = $collection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    public function getData()
    {
        $id = $this->request->getParam('id');
        if (isset($id)) {
            $carrier = $this->collection->getItemById($id);
            if (!isset($carrier)) {
                throw new NoSuchEntityException(
                    __('The carrier with "%1" id does not exist', $id)
                );
            }
            return [$id => $carrier->getData()];
        }
        return parent::getData();
    }
}