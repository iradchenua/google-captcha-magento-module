<?php


namespace Ivan\MyNewAttribute\ViewModel\SizeChart;

class SizeChart implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    private $jsonHelper;
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        \Magento\Framework\Serialize\Serializer\Json $jsonHelper,
        \Magento\Framework\Registry $registry
    )
    {
        $this->jsonHelper = $jsonHelper;
        $this->registry = $registry;
    }
    public function getSizeChartValue()
    {
        $product = $this->getProduct();
        $jsonValue = $product->getSizeChart();
        if ($jsonValue == false) {
            return [];
        }
        return $this->jsonHelper->unserialize($jsonValue);
    }
    private function getProduct() {
        return $this->registry->registry('product');
    }
}
