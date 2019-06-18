<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface $entityManager
     */
    public function __construct(
        EasycreditEntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function saveOrderIdentifier(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): PaymentEasycreditOrderIdentifierTransfer
    {
        $paymentEasycreditOrderIdentifierTransfer = new PaymentEasycreditOrderIdentifierTransfer();

        if ($quoteTransfer->getPayment()->getPaymentSelection() !== EasycreditConfig::PAYMENT_METHOD) {
            return $paymentEasycreditOrderIdentifierTransfer;
        }

        $paymentEasycreditOrderIdentifierTransfer->setIdentifier($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        $paymentEasycreditOrderIdentifierTransfer->setFkSalesOrder($saveOrderTransfer->getIdSalesOrder());
        $paymentEasycreditOrderIdentifierTransfer->setConfirmed(false);

        return $this->entityManager->saveEasycreditOrderIdentifier($paymentEasycreditOrderIdentifierTransfer);
    }
}
