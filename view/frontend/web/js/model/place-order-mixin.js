define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (placeOrderAction) {
        return wrapper.wrap(
            placeOrderAction,
            function (originalAction, paymentData, messageContainer) {
                if (!paymentData.extension_attributes) {
                    paymentData.extension_attributes = {};
                }

                paymentData.extension_attributes.checkout_newsletter_subscribe = $('#checkout-newsletter-subscribe').prop('checked');

                return originalAction(paymentData, messageContainer);
            }
        );
    };
});
