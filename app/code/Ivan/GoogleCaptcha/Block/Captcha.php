<?php


namespace Ivan\GoogleCaptcha\Block;


use Magento\Framework\View\Element\Template;

class Captcha extends \Magento\Framework\View\Element\Template
{
    private $dataProvider;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ivan\GoogleCaptcha\Model\DataProvider $dataProvider,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->dataProvider = $dataProvider;
    }

    public function getCaptchaType()
    {
        return $this->dataProvider->getCaptchaType();
    }

    public function getPublicSiteKey()
    {
        return $this->dataProvider->getPublicSiteKey();
    }

    public function getIsEnabled()
    {
        return $this->dataProvider->getIsEnabled();
    }
}
