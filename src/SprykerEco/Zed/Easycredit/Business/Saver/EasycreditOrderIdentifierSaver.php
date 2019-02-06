<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Saver;

use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface;

class EasycreditOrderIdentifierSaver implements EasycreditOrderIdentifierSaverInterface
{
    /**
     * @var EasycreditEntityManagerInterface
     */
    protected $entityManager;

    public function __construct(
        EasycreditEntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     * @param SaveOrderTransfer $saveOrderTransfer
     *
     * @return PaymentEasycreditOrderIdentifierTransfer|null
     */
    public function saveOrderIdentifier(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): ?PaymentEasycreditOrderIdentifierTransfer
    {
        if ($quoteTransfer->getPayment()->getPaymentSelection() == EasycreditConfig::PAYMENT_METHOD) {
            $paymentEasycreditOrderIdentifierTransfer = new PaymentEasycreditOrderIdentifierTransfer();
            $paymentEasycreditOrderIdentifierTransfer->setIdentifier($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
            $paymentEasycreditOrderIdentifierTransfer->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder());
            $paymentEasycreditOrderIdentifierTransfer->setConfirmed(false);

            return $this->entityManager->saveEasycreditOrderIdentifier($paymentEasycreditOrderIdentifierTransfer);
        }
    }
}
