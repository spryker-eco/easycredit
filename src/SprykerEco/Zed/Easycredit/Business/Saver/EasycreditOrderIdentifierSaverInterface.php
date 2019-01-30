<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Saver;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface EasycreditOrderIdentifierSaverInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     * @param SaveOrderTransfer $saveOrderTransfer
     */
    public function saveOrderIdentifier(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void;
}
