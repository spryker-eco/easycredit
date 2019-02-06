<?php

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;

class OrderConfirmationResponseParser implements ParserInterface
{
    protected const KEY_WS_MESSAGES = 'wsMessages';
    protected const KEY_MESSAGES = 'messages';
    protected const KEY_KEY = 'key';
    protected const VALUE_SUCCESS_CONFIRMATION = 'BestellungBestaetigenServiceActivity.Infos.ERFOLGREICH';

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditOrderConfirmationResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_WS_MESSAGES, $payload) && !$easycreditResponseTransfer->getError()) {
            if (array_key_exists(static::KEY_MESSAGES, $payload[static::KEY_WS_MESSAGES])) {
                $transfer->setConfirmed($payload[static::KEY_WS_MESSAGES][static::KEY_MESSAGES][0][static::KEY_KEY]
                == static::VALUE_SUCCESS_CONFIRMATION ? true : false);
                $transfer->setSuccess(true);
            }
        }

        return $transfer;
    }
}
