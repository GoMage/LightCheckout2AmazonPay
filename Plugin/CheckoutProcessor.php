<?php

namespace GoMage\LCAmazonPay\Plugin;

use Amazon\Core\Helper\Data as AmazonHelper;
use GoMage\LCAmazonPay\Model\Config\CheckoutConfigProvider;
use GoMage\LightCheckout\Block\Checkout\LayoutProcessor;

class CheckoutProcessor
{
    /**
     * @var AmazonHelper
     */
    protected $amazonHelper;
    /**
     * @var CheckoutConfigProvider
     */
    protected $configProvider;

    protected $shippingConfig;
    protected $paymentConfig;
    protected $sidebarConfig;

    /**
     * CheckoutProcessor constructor.
     *
     * @param AmazonHelper $amazonHelper
     * @param CheckoutConfigProvider $configProvider
     */
    public function __construct(
        AmazonHelper $amazonHelper,
        CheckoutConfigProvider $configProvider
    ) {
        $this->amazonHelper = $amazonHelper;
        $this->configProvider = $configProvider;
    }

    /**
     * Checkout LayoutProcessor after process plugin.
     *
     * @param LayoutProcessor $processor
     * @param array $jsLayout
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterProcess(LayoutProcessor $processor, $jsLayout)
    {
        $this->shippingConfig = &$jsLayout['components']['checkout']['children']['shippingAddress'];
        $this->paymentConfig = &$jsLayout['components']['checkout']['children']['payment'];
        $this->sidebarConfig = &$jsLayout['components']['checkout']['children']['sidebar']['children']['placeOrderButtonAfter']['children'];
        $this->emailConfig =  &$jsLayout['components']['checkout']['children']['customer-email'];
        
        if ($this->processAmazonEnabled()) {
            $this->processAmazomButtonPosition();
        }
        return $jsLayout;
    }

    protected function processAmazonEnabled()
    {
        if ($this->amazonHelper->isPwaEnabled()
            && $this->configProvider->isAmazonIntegrationEnabled()
        ) {
            $this->shippingConfig['component'] = 'GoMage_LCAmazonPay/js/view/shipping';
            $this->emailConfig['component'] = 'GoMage_LCAmazonPay/js/view/form/element/email';
            $this->shippingConfig['children']['address-list']['component'] = 'Amazon_Payment/js/view/shipping-address/list';
            $this->shippingConfig['children']['shipping-address-fieldset']['children']
            ['inline-form-manipulator']['component'] = 'Amazon_Payment/js/view/shipping-address/inline-form';
            $this->paymentConfig['children']['payments-list']['component'] = 'GoMage_LCAmazonPay/js/view/payment/list';

            return true;
        } else {
            unset($this->sidebarConfig['amazon-button-region']);
            unset($this->shippingConfig['children']['before-form']['children']['amazon-widget-address']);
            unset($this->paymentConfig['children']['renders']['children']['amazon_payment']);
            unset($this->paymentConfig['children']['beforeMethods']['children']['amazon-sandbox-simulator']);
            unset($this->paymentConfig['children']['payments-list']['children']['amazon_payment-form']);

            return false;
        }
    }

    protected function processAmazomButtonPosition()
    {
        if ($this->configProvider->displayInPaymentMethodsList()) {
            unset($this->sidebarConfig['amazon-button-region']['children']['amazon-button']);
        } else {
            unset($this->paymentConfig['children']['renders']['children']['amazon_payment']);
        }
    }


}
