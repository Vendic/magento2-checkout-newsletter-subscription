define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function ($, ko, Component, customerData) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Vendic_CheckoutNewsletterSubscription/subscribe',
            isVisible: ko.observable(true),
            isChecked: ko.observable(true)
        },

        initialize: function () {
            this._super();
            var self = this,
                defaultValue = true;

            if (window.checkoutConfig.newsletter_subscription_default !== undefined) {
                defaultValue = window.checkoutConfig.newsletter_subscription_default;
            }

            self.isChecked(typeof(customerData.get('checkoutNewsletterSubscribe')()) == 'boolean'
                ? customerData.get('checkoutNewsletterSubscribe')() : Boolean(defaultValue));

            $(document).on('change', 'input[name="checkout_newsletter_subscribe"]', function () {
                self.isChecked($(this).prop('checked'));
                customerData.set('checkoutNewsletterSubscribe', self.isChecked());
            });
        }
    });
});
