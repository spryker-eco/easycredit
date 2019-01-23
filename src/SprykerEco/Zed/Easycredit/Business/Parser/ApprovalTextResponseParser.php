<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;

class ApprovalTextResponseParser implements ParserInterface
{
    protected const KEY_TEXT_IDENTIFIER = 'ustimmungDatenuebertragungPaymentPage';

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

        $transfer = new EasycreditApprovalTextResponseTransfer();

        if (array_key_exists(static::KEY_TEXT_IDENTIFIER, $payload)) {
            $transfer->setText($payload[static::KEY_TEXT_IDENTIFIER]);
        }

        return $transfer;
    }
}
