/*global define*/
define(
    [
        'jquery',
        'underscore',
        'ko',
        'GoMage_LightCheckout/js/view/shipping',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/model/step-navigator',
        'Amazon_Payment/js/model/storage'
    ],
    function (
        $,
        _,
        ko,
        Component,
        customer,
        setShippingInformationAction,
        stepNavigator,
        amazonStorage
    ) {
        'use strict';

        return Component.extend({

            /**
             * Initialize shipping
             */
            initialize: function () {
                this._super();
                this.isNewAddressAdded(amazonStorage.isAmazonAccountLoggedIn());
                amazonStorage.isAmazonAccountLoggedIn.subscribe(function (value) {
                    this.isNewAddressAdded(value);
                }, this);
                if (amazonStorage.isAmazonAccountLoggedIn()) {
                    this.addressOptions = [];
                }
                return this;
            },

            /**
             * Validate guest email
             */
            validateGuestEmail: function () {
                var loginFormSelector = 'form[data-role=email-with-possible-login]';

                $(loginFormSelector).validation();

                return $(loginFormSelector + ' input[type=email]').valid();
            },

            /**
             * New setShipping Action for Amazon Pay to bypass validation
             */
            setShippingInformation: function () {

            },
            afterRenderShipping: function () {
                if (amazonStorage.isAmazonAccountLoggedIn()) {
                    $('#shipping').show();
                    $('.glc-billing-address').hide();
                }
            }
        });
    }
);
