<?php


namespace Ivan\MyNewAttribute\Model\SizeChart\Frontend;


use Magento\Eav\Model\Entity\Attribute\Source\BooleanFactory;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\Serializer\Json as Serializer;
use Magento\Store\Model\StoreManagerInterface;

class SizeChart extends \Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend
{
    private $resultPageFactory;

    public function __construct(
        BooleanFactory $attrBooleanFactory, CacheInterface $cache = null,
        $storeResolver = null, array $cacheTags = null,
        StoreManagerInterface $storeManager = null,
        Serializer $serializer = null,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($attrBooleanFactory, $cache, $storeResolver, $cacheTags, $storeManager, $serializer);
        $this->resultPageFactory = $resultPageFactory;

    }

    public function getValue(\Magento\Framework\DataObject $object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if ($value == "") {
            return false;
        }
        $resultPage = $this->resultPageFactory ->create();
        $blockInstance = $resultPage->getLayout()
            ->createBlock('Ivan\MyNewAttribute\Block\SizeChart')
            ->setTemplate('Ivan_MyNewAttribute::default/size_chart.phtml')
            ->setSizeChartValue($value);
        return $blockInstance->toHtml();
    }
}