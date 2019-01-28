<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;

interface EasycreditEntityManagerInterface
{
    /**
     * @param PaymentEasycreditApiLogTransfer $apiLogTransfer
     *
     * @return mixed
     */
    public function saveEasycreditApiLog(PaymentEasycreditApiLogTransfer $apiLogTransfer): PaymentEasycreditApiLogTransfer;
}
