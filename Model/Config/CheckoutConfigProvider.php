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
    const XML_PATH_LIGHT_CHECKOUT_AMAZON_DISPLAY_IN_PAYMENT_LIST = 'gomage_light_checkout_configuration/payment_methods/amazon_display_in_payment_list';

    public function isAmazonIntegrationEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_LIGHT_CHECKOUT_AMAZON_INTEGRATION_ENABLED);
    }

    public function displayInPaymentMethodsList()
    {
        return (int)$this->scopeConfig->getValue(self::XML_PATH_LIGHT_CHECKOUT_AMAZON_DISPLAY_IN_PAYMENT_LIST);
    }
}