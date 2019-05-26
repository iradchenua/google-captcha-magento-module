<?php


namespace Ivan\DynamicShipping\Controller\Adminhtml\Edit;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\Framework\App\Cache\TypeListInterface as CacheTypeListInterface;

class Delete extends Action implements HttpGetActionInterface, HttpPostActionInterface
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
    private function deleteFromConfig($carrier)
    {
        $path = "carriers/dynamic_" . $carrier->getCode();
        $this->coreConfig->deleteConfig(
            $path . "/title"
        );
        $this->coreConfig->deleteConfig(
            $path . "/active"
        );
        $this->coreConfig->deleteConfig(
            $path .'/model'
        );
        $this->coreConfig->deleteConfig(
            $path .'/showmethod'
        );
        $this->coreConfig->deleteConfig(
            $path .'/price'
        );
        $this->coreConfig->deleteConfig(
            $path .'/name'
        );
    }
    public function execute()
    {
        $postValues = $this->getRequest()->getPostValue();
        $carrier = $this->dynamicCarrierFactory->create();
        foreach($postValues['selected'] as $selectedId) {
            $this->resourceModel->load($carrier, $selectedId);
            $carrier->load($selectedId);
            $this->deleteFromConfig($carrier);
            $this->resourceModel->delete($carrier);
        }
        $this->messageManager->addSuccessMessage('carrier/s was/were deleted');
        $this->cache->invalidate(['full_page', 'config']);
        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/manage/index', ['error' => false]);
    }
}