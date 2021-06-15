<?php
declare(strict_types=1);

namespace Vendic\CheckoutNewsletterSubscription\Plugin\Model;

use Magento\Newsletter\Model\Subscriber;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Psr\Log\LoggerInterface;

class PaymentInformationManagement
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var Subscriber
     */
    private $subscriber;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PaymentInformationManagement constructor.
     * @param CartRepositoryInterface $cartRepository
     * @param Subscriber $subscriber
     * @param LoggerInterface $logger
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        Subscriber $subscriber,
        LoggerInterface $logger
    ) {
        $this->cartRepository = $cartRepository;
        $this->subscriber = $subscriber;
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Checkout\Model\PaymentInformationManagement $subject
     * @param $cartId
     * @param PaymentInterface $paymentMethod
     * @param AddressInterface|null $billingAddress
     * @phpstan-ignore-next-line
     */
    public function beforeSavePaymentInformationAndPlaceOrder(
        \Magento\Checkout\Model\PaymentInformationManagement $subject,
        $cartId,
        PaymentInterface $paymentMethod,
        AddressInterface $billingAddress = null
    ) {
        // phpcs:disable Generic.Files.LineLength
        /* @phpstan-ignore-next-line */
        if ($paymentMethod->getExtensionAttributes() && $paymentMethod->getExtensionAttributes()->getCheckoutNewsletterSubscribe()) {
            try {
                $quote = $this->cartRepository->getActive($cartId);
                $this->subscriber->subscribeCustomerById((int) $quote->getCustomer()->getId());
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }
}
