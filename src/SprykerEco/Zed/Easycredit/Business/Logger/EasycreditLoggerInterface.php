<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Logger;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface EasycreditLoggerInterface
{
    public const LOG_TYPE_PAYMENT_INITIALIZE = 'payment_initialize';
    public const LOG_TYPE_CREDIT_ASSESSMENT = 'credit_assessment';
    public const LOG_TYPE_ORDER_CONFIRMATION = 'order_confirmation';
    public const LOG_TYPE_APPROVAL_TEXT = 'approval_text';

    public function saveApiLog(string $type, AbstractTransfer $request, AbstractTransfer $response): PaymentEasycreditApiLogTransfer;
}
