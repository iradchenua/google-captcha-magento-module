<?php


namespace Ivan\DynamicShipping\Controller\Adminhtml\Manage;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;

class Index  extends Action implements HttpGetActionInterface
{
    protected $resultPageFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}