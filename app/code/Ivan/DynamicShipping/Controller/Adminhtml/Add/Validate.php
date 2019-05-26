<?php


namespace Ivan\DynamicShipping\Controller\Adminhtml\Add;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action;

class Validate extends Action implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
    private $message;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    private $layoutFactory;
    /**
     * @var \Ivan\DynamicShipping\Model\DynamicCarrierFactory
     */
    private $dynamicCarrierFactory;
    /**
     * @var \Ivan\DynamicShipping\Model\ResourceModel\DynamicCarrier
     */
    private $resourceModel;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Ivan\DynamicShipping\Model\DynamicCarrierFactory $dynamicCarrierFactory,
        \Ivan\DynamicShipping\Model\ResourceModel\DynamicCarrier $resourceModel,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->formKeyValidator = $formKeyValidator;
        $this->layoutFactory = $layoutFactory;
        $this->dynamicCarrierFactory = $dynamicCarrierFactory;
        $this->resourceModel = $resourceModel;
    }

    private function isValid()
    {
        $request = $this->getRequest();
        $postValues = $request->getPostValue();
        if (!$this->formKeyValidator->validate($request)) {
            return [
                'isValid' => false,
                'message' =>'invalid form key'
            ];
        }
        if (isset($postValues['dynamicshipping_id'])) {
            $carrier = $this->dynamicCarrierFactory->create();
            $this->resourceModel->load($carrier, $postValues['dynamicshipping_id']);
        }
        if (empty(trim($postValues['code'])) ||
            empty(trim($postValues['name'])) ||
            empty(trim($postValues['shipping_method'])) ||
            empty($postValues['price']) ||
            empty($postValues['is_active'])) {
            return [
                'isValid' => false,
                'message' =>'inputs must not contain empty fields or consist only from space characters'
            ];
        }
        if (!is_numeric($postValues['is_active']) ||
            !is_numeric($postValues['price'])) {
            return [
                'isValid' => false,
                'message' =>'price and active button must be numeric'
            ];
        }
        return ['isValid' => true];
    }

    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $isValidArr = $this->isValid();
        if (!$isValidArr['isValid']) {
            $response->setMessage($isValidArr['message']);
            $layout = $this->layoutFactory->create();
            $layout->initMessages();
            $response->setHtmlMessage($layout->getMessagesBlock()->getGroupedHtml());
        }
        $response->setError(!$isValidArr['isValid']);
        return $this->resultJsonFactory->create()->setData($response);
    }
}
