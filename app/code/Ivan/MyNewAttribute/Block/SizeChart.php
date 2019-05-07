<?php


namespace Ivan\MyNewAttribute\Block;


use Magento\Framework\View\Element\Template;

class SizeChart extends \Magento\Framework\View\Element\Template
{
    private $sizeChartValue;
    private $jsonHelper;

    public function __construct(
        Template\Context $context,
        \Magento\Framework\Serialize\Serializer\Json $jsonHelper,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * @return array
     */
    public function getSizeChartValue()
    {
        return $this->sizeChartValue;
    }

    /**
     * @param string $sizeChartValue
     */
    public function setSizeChartValue($sizeChartValue): SizeChart
    {
        $this->sizeChartValue = $this->jsonHelper->unserialize($sizeChartValue);
        return $this;
    }

}