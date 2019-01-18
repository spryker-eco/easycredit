<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface EasycreditPaymentInitializeProcessorInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer;
}
