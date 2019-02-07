<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class InitializePaymentResponseParser implements ParserInterface
{
    protected const KEY_PAYMENT_IDENTIFIER = 'tbVorgangskennung';

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
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
