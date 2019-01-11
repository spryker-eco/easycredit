<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\PaymentProcessor;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface EasycreditPaymentProcessorInterface
{
    /**
     * @param QuoteTransfer $transfer
     *
     * @return AbstractTransfer
     */
    public function process(QuoteTransfer $transfer): AbstractTransfer;
}
