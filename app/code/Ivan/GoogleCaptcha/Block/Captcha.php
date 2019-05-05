<?php


namespace Ivan\GoogleCaptcha\Block;


use Magento\Framework\View\Element\Template;

class Captcha extends \Magento\Customer\Block\Form\Login
{
    private $helperData;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Url $customerUrl,
        \Ivan\GoogleCaptcha\Helper\Data $helperData,
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $customerUrl, $data);
        $this->helperData = $helperData;
    }

    public function getHelperData()
    {
        return $this->helperData;
    }
}
