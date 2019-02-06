<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class ApprovalTextResponseParser implements ParserInterface
{
    protected const KEY_TEXT_IDENTIFIER = 'zustimmungDatenuebertragungPaymentPage';

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditApprovalTextResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_TEXT_IDENTIFIER, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setText($payload[static::KEY_TEXT_IDENTIFIER]);
        }

        return $transfer;
    }
}
