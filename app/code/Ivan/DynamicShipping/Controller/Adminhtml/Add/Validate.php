<?php


namespace Ivan\DynamicShipping\Controller\Adminhtml\Add;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action;

class Validate extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->formKeyValidator = $formKeyValidator;
    }

    private function isValidPostValues($postValues)
    {
        if (empty(trim($postValues['carrier_code'])) ||
            empty(trim($postValues['carrier_name'])) ||
            empty(trim($postValues['shipping_method'])) ||
            empty($postValues['shipping_price']) ||
            empty($postValues['carrier_is_active'])) {
            $this->messageManager->addErrorMessage(
                'inputs must not contain empty fields or consist only from space characters'
            );
            return false;
        }
        if (!is_numeric($postValues['carrier_is_active']) ||
            !is_numeric($postValues['shipping_price'])) {
            $this->messageManager->addErrorMessage(
                'price and active button must be numeric'
            );
            return false;
        }
        return true;
    }

    public function execute()
    {

        $postValues = $this->getRequest()->getPostValue();
        $resultJson = $this->resultJsonFactory->create();
        $isError = !$this->formKeyValidator->validate($this->getRequest());
        $isError = $isError || !$this->isValidPostValues($postValues);
        $resultJson->setData(['error' => $isError]);
        return $resultJson;
    }
}
