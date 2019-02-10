<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Handler;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface EasycreditPaymentHandlerInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentToQuote(AbstractTransfer $quoteTransfer): AbstractTransfer;
}
