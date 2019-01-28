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
    public function saveApiLog(string $type, AbstractTransfer $request, AbstractTransfer $response): PaymentEasycreditApiLogTransfer;
}
