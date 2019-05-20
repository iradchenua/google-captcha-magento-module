<?php


namespace Ivan\DynamicShipping\Controller\Adminhtml\Edit;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\Framework\App\Cache\TypeListInterface as CacheTypeListInterface;

class Save extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    private $dynamicCarrierFactory;
    /**
     * @var \Ivan\DynamicShipping\Model\ResourceModel\DynamicCarrier
     */
    private $resourceModel;
    /**
     * @var \Magento\Framework\App\Config\ConfigResource\ConfigInterface
     */
    private $coreConfig;
    /**
     * @var \Magento\Quote\Model\ResourceModel\Quote\Address\RateFactory
     */
    private $rateFactory;
    /**
     * @var CacheTypeListInterface
     */
    private $cache;
    /**
     * @var CacheManager
     */
    private $cacheManager;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Ivan\DynamicShipping\Model\DynamicCarrierFactory $dynamicCarrierFactory,
        \Ivan\DynamicShipping\Model\ResourceModel\DynamicCarrier $resourceModel,
        \Magento\Framework\App\Config\ConfigResource\ConfigInterface $coreConfig,
        CacheTypeListInterface $cache,
        CacheManager $cacheManager

    ) {
        parent::__construct($context);
        $this->dynamicCarrierFactory = $dynamicCarrierFactory;
        $this->resourceModel = $resourceModel;
        $this->coreConfig = $coreConfig;
        $this->cache = $cache;
        $this->cacheManager = $cacheManager;
    }

    private function saveToConfig($newCarrier)
    {
        $path = "carriers/dynamic_" . $newCarrier->getCode();
        $this->coreConfig->saveConfig(
             $path . "/title",
            $newCarrier->getName()
        );
        $this->coreConfig->saveConfig(
            $path . "/active",
            $newCarrier->getIsActive()
        );
        $this->coreConfig->saveConfig(
            $path .'/model',
            \Ivan\DynamicShipping\Model\ShippingTemplate::class
        );
        $this->coreConfig->saveConfig(
            $path .'/showmethod',
            1
        );
        $this->coreConfig->saveConfig(
            $path .'/price',
            $newCarrier->getPrice()
        );
        $this->coreConfig->saveConfig(
            $path .'/name',
            $newCarrier->getShippingMethod()
        );
    }

    private function saveToModel($newCarrier, $postValues)
    {

        $newCarrier->setCode(trim($postValues['carrier_code']));
        $newCarrier->setName(trim($postValues['carrier_name']));
        $newCarrier->setIsActive($postValues['carrier_is_active']);
        $newCarrier->setShippingMethod(trim($postValues['shipping_method']));
        $newCarrier->setPrice($postValues['shipping_price']);
        $this->resourceModel->save($newCarrier);
    }
    public function execute()
    {
        $postValues = $this->getRequest()->getPostValue();
        $newCarrier = $this->dynamicCarrierFactory->create();
        $this->saveToModel($newCarrier, $postValues);
        $this->saveToConfig($newCarrier);
        $this->messageManager->addSuccessMessage('new carrier was created');
        $this->cache->invalidate(['full_page', 'config']);
        return $this->resultFactory
                ->create(ResultFactory::TYPE_REDIRECT)
                ->setPath('dynamicshipping/add/index', ['error' => false]);
    }
}
