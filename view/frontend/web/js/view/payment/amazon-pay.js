define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list',
    'Amazon_Payment/js/model/storage'

], function (
    Component,
    rendererList,
    amazonStorage
) {
    'use strict';

    rendererList.push(
        {
            type: 'amazon_payment',
            component: 'GoMage_LCAmazonPay/js/view/payment/amazon-payment-widget'
        }
    );

    /** Add view logic here if needed */
    return Component.extend({});
});
