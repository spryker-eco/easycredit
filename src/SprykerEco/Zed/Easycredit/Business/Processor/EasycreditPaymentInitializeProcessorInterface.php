<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface EasycreditPaymentInitializeProcessorInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer;
}
