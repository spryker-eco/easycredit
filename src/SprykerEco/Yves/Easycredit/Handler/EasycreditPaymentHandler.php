<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function addPaymentToQuote(QuoteTransfer $quoteTransfer): AbstractTransfer
    {
        $quoteTransfer->getPaymentOrFail()
            ->setPaymentProvider(static::PAYMENT_PROVIDER)
            ->setPaymentMethod(static::PAYMENT_PROVIDER);

        return $quoteTransfer;
    }
}
