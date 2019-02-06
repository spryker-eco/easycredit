<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class InitializePaymentResponseParser implements ParserInterface
{
    protected const KEY_PAYMENT_IDENTIFIER = 'tbVorgangskennung';

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditInitializePaymentResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_PAYMENT_IDENTIFIER, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setPaymentIdentifier($payload[static::KEY_PAYMENT_IDENTIFIER]);
            $transfer->setSuccess(true);
        }

        return $transfer;
    }
}
