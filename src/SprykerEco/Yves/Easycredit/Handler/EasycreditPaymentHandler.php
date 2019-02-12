<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Handler;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;

class EasycreditPaymentHandler implements EasycreditPaymentHandlerInterface
{
    public const PAYMENT_PROVIDER = EasycreditConfig::PROVIDER_NAME;

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(AbstractTransfer $quoteTransfer): AbstractTransfer
    {
        $quoteTransfer->getPayment()
            ->setPaymentProvider(static::PAYMENT_PROVIDER)
            ->setPaymentMethod(static::PAYMENT_PROVIDER);

        return $quoteTransfer;
    }
}
