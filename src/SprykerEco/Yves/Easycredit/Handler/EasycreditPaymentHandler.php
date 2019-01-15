<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Easycredit\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;

class EasycreditPaymentHandler implements EasycreditPaymentHandlerInterface
{
    public const PAYMENT_PROVIDER = EasycreditConfig::PROVIDER_NAME;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(AbstractTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer->getPayment()
            ->setPaymentProvider(static::PAYMENT_PROVIDER)
            ->setPaymentMethod(static::PAYMENT_PROVIDER);

        return $quoteTransfer;
    }
}