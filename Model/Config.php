<?php
declare(strict_types=1);

namespace Vendic\CheckoutNewsletterSubscription\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getIsCheckedByDefault()
    {
        return $this->scopeConfig->isSetFlag(
            'vendic_checkout_newsletter_subscribe/general/checked_by_default',
            ScopeInterface::SCOPE_STORE
        );
    }
}
