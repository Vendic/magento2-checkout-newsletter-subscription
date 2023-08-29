<?php

namespace Vendic\CheckoutNewsletterSubscription\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Vendic\CheckoutNewsletterSubscription\Model\Config;

class CheckoutConfigProvider implements ConfigProviderInterface
{
    public function __construct(
        private Config $config
    ) {
    }

    public function getConfig(): array
    {
        $configArray = [];
        $configArray['newsletter_subscription_default'] = $this->config->getIsCheckedByDefault();
        return $configArray;
    }
}
