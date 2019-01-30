<?php

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
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
     * @var EasycreditToUtilEncodingServiceInterface
     */
    protected $utilEncoding;

    /**
     * @param EasycreditToUtilEncodingServiceInterface $utilEncoding
     */
    public function __construct(EasycreditToUtilEncodingServiceInterface $utilEncoding)
    {
        $this->utilEncoding = $utilEncoding;
    }

    /**
     * @param StreamInterface $response
     *
     * @return AbstractTransfer
     */
    public function parse(StreamInterface $response): AbstractTransfer
    {
        $payload = $this->utilEncoding->decodeJson($response->getContents(), true);

        $transfer = new EasycreditOrderConfirmationResponseTransfer();

        $transfer->setConfirmed($payload[static::KEY_WS_MESSAGES][static::KEY_MESSAGES][0][static::KEY_KEY]
            == static::VALUE_SUCCESS_CONFIRMATION ? true : false);

        return $transfer;
    }
}
