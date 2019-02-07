<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class ApprovalTextResponseParser implements ParserInterface
{
    protected const KEY_TEXT_IDENTIFIER = 'zustimmungDatenuebertragungPaymentPage';

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
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
