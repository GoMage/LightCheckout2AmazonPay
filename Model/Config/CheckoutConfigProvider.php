<?php

namespace GoMage\LCAmazonPay\Model\Config;

use GoMage\LightCheckout\Model\Config\CheckoutConfigurationsProvider;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CheckoutConfigProvider
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {

        $this->scopeConfig = $scopeConfig;
    }

    const XML_PATH_LIGHT_CHECKOUT_AMAZON_INTEGRATION_ENABLED = 'gomage_light_checkout_configuration/payment_methods/is_amazon_enabled';

    public function isAmazonIntegrationEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_LIGHT_CHECKOUT_AMAZON_INTEGRATION_ENABLED);
    }
}