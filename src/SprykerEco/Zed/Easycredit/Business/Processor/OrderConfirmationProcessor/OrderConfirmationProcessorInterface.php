<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor;

use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;

interface OrderConfirmationProcessorInterface
{
    /**
     * @param int $idOrder
     *
     * @return EasycreditOrderConfirmationResponseTransfer
     */
    public function process(int $idOrder): EasycreditOrderConfirmationResponseTransfer;
}
