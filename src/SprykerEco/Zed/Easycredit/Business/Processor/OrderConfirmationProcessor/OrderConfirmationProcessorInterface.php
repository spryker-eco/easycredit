<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor;

use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;

interface OrderConfirmationProcessorInterface
{
    /**
     * @param int $fkSalesOrder
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function process(int $fkSalesOrder): EasycreditOrderConfirmationResponseTransfer;
}
