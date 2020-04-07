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
        $shippingConfig = &$jsLayout['components']['checkout']['children']['shippingAddress'];
        $paymentConfig = &$jsLayout['components']['checkout']['children']['payment'];
        $sidebarConfig = &$jsLayout['components']['checkout']['children']['sidebar']['children']['placeOrderButtonAfter']['children'];
        $emailConfig =  &$jsLayout['components']['checkout']['children']['customer-email'];

        if ($this->amazonHelper->isPwaEnabled()
            && $this->configProvider->isAmazonIntegrationEnabled()
        ) {
            $shippingConfig['component'] = 'GoMage_LCAmazonPay/js/view/shipping';
            $emailConfig['component'] = 'GoMage_LCAmazonPay/js/view/form/element/email';
            $shippingConfig['children']['address-list']['component'] = 'Amazon_Payment/js/view/shipping-address/list';
            $shippingConfig['children']['shipping-address-fieldset']['children']
            ['inline-form-manipulator']['component'] = 'Amazon_Payment/js/view/shipping-address/inline-form';
            $paymentConfig['children']['payments-list']['component'] = 'GoMage_LCAmazonPay/js/view/payment/list';
        } else {
            unset($sidebarConfig['amazon-button-region']);
            unset($shippingConfig['children']['before-form']['children']['amazon-widget-address']);
            unset($paymentConfig['children']['renders']['children']['amazon_payment']);
            unset($paymentConfig['children']['beforeMethods']['children']['amazon-sandbox-simulator']);
            unset($paymentConfig['children']['payments-list']['children']['amazon_payment-form']);
        }

        return $jsLayout;
    }
}
