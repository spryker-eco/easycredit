<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;

interface EasycreditEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer $apiLogTransfer
     *
     * @return PaymentEasycreditApiLogTransfer
     */
    public function saveEasycreditApiLog(PaymentEasycreditApiLogTransfer $apiLogTransfer): PaymentEasycreditApiLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function saveEasycreditOrderIdentifier(PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer): PaymentEasycreditOrderIdentifierTransfer;
}
