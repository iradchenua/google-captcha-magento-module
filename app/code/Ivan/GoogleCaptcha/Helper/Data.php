<?php


namespace Ivan\GoogleCaptcha\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $publicSiteKey;
    protected $privateSiteKey;
    protected $isEnabled;
    protected $isInvisible;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig

    )
    {
        parent::__construct($context);


        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $this->isEnabled = $scopeConfig->getValue(
            "googlecaptcha/general/enable",
            $storeScope
        );
        $this->isInvisible = \Ivan\GoogleCaptcha\Model\Config\Source\ListMode::INVISIBLE === $scopeConfig->getValue(
                "googlecaptcha/general/captcha_type",
                $storeScope
        );
        $keyPrefix = ($this->isInvisible ? 'invisible' : 'checkbox');
        $privateKey = $keyPrefix . '_private_key';
        $publicKey = $keyPrefix . '_public_key';
        $this->privateSiteKey = $scopeConfig->getValue(
            "googlecaptcha/general/$privateKey",
            $storeScope
        );
        $this->publicSiteKey = $scopeConfig->getValue(
            "googlecaptcha/general/$publicKey",
            $storeScope
        );
    }

    /**
     * @return string
     */
    public function getPublicSiteKey()
    {
        return $this->publicSiteKey;
    }

    /**
     * @return string
     */
    public function getPrivateSiteKey()
    {
        return $this->privateSiteKey;
    }

    /**
     * @return bool
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }
    /**
     * @return bool
     */
    public function getIsInvisible()
    {
        return $this->isInvisible;
    }
    /**
     * @return bool
     */
    public function getIsCheckBox()
    {
        return !$this->isInvisible;
    }
}