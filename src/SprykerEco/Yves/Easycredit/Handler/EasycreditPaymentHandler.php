<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;

class EasycreditPaymentHandler implements EasycreditPaymentHandlerInterface
{
    public const PAYMENT_PROVIDER = EasycreditConfig::PROVIDER_NAME;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $paymentTransfer = $quoteTransfer->getPayment();

        if (!$paymentTransfer) {
            return $quoteTransfer;
        }

        $paymentTransfer
            ->setPaymentProvider(static::PAYMENT_PROVIDER)
            ->setPaymentMethod(static::PAYMENT_PROVIDER);

        return $quoteTransfer->setPayment($paymentTransfer);
    }
}
