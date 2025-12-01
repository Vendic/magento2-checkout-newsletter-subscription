<?php
declare(strict_types=1);

namespace Vendic\CheckoutNewsletterSubscription\Plugin\Model;

use Magento\Checkout\Api\GuestPaymentInformationManagementInterface;
use Magento\Newsletter\Model\SubscriberFactory;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Magento\Newsletter\Model\Subscriber;
use Psr\Log\LoggerInterface;

class GuestPaymentInformationManagement
{
    /**
     * @var Subscriber
     */
    private $subscriber;

    /**
     * @var SubscriberFactory
     */
    private $subscriberFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * GuestPaymentInformationManagement constructor.
     * @param Subscriber $subscriber
     * @param SubscriberFactory $subscriberFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Subscriber $subscriber,
        SubscriberFactory $subscriberFactory,
        LoggerInterface $logger
    ) {
        $this->subscriber = $subscriber;
        $this->subscriberFactory = $subscriberFactory;
        $this->logger = $logger;
    }

    /**
     * @param GuestPaymentInformationManagementInterface $subject
     * @param $cartId
     * @param $email
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     * @phpstan-ignore-next-line
     */
    public function beforeSavePaymentInformationAndPlaceOrder(
        GuestPaymentInformationManagementInterface $subject,
        $cartId,
        string $email,
        PaymentInterface $paymentMethod,
        ?AddressInterface $billingAddress = null
    ) {
        // phpcs:disable Generic.Files.LineLength
        /* @phpstan-ignore-next-line */
        if ($paymentMethod->getExtensionAttributes() && $paymentMethod->getExtensionAttributes()->getCheckoutNewsletterSubscribe()) {
            try {
                $this->subscriber->subscribe($email);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }
}
