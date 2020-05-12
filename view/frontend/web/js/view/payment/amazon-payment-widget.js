define(
    [
        'Amazon_Payment/js/view/payment/method-renderer/amazon-payment-widget',
    ],
    function (
        Component,
    ) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'GoMage_LCAmazonPay/amazon-payment-widget'
            },
        });
    });
