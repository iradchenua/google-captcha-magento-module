<?php


namespace Ivan\GoogleCaptcha\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class DataProvider
{
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return string
     */
    public function getPublicSiteKey()
    {
        return $this->scopeConfig->getValue(
            "googlecaptcha/general/{$this->getCaptchaType()}_public_key",
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     */
    public function getPrivateSiteKey()
    {
        return $this->scopeConfig->getValue(
            "googlecaptcha/general/{$this->getCaptchaType()}_private_key",
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function getIsEnabled()
    {
        return $this->scopeConfig->getValue(
            "googlecaptcha/general/enable",
            ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * @return string
     */
    public function getCaptchaType()
    {
        return $this->scopeConfig->getValue(
            "googlecaptcha/general/captcha_type",
            ScopeInterface::SCOPE_STORE
        );
    }
}
