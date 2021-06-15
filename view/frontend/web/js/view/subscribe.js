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

        init: function (config, element) {
            this._super();
            var self = this;

            self.isChecked = typeof(customerData.get('checkoutNewsletterSubscribe')()) == 'boolean'
                ? customerData.get('checkoutNewsletterSubscribe')() : true;

            $(document).on('change', 'input[name="checkout_newsletter_subscribe"]', function () {
                self.isChecked = $(this).prop('checked');
                customerData.set('checkoutNewsletterSubscribe', self.isChecked);
            });
        }
    });
});
