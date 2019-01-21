<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;

class QueryCreditAssessmentResponseParser implements ParserInterface
{
    protected const KEY_ENTSCHEIDUNG = 'entscheidung';
    protected const KEY_ENTSCHEIDUNG_SERGEBNIS = 'entscheidungsergebnis';
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

        $transfer = new EasycreditQueryAssessmentResponseTransfer();

        if (array_key_exists(static::KEY_ENTSCHEIDUNG, $payload)) {
            $transfer->setStatus($payload[static::KEY_ENTSCHEIDUNG][static::KEY_ENTSCHEIDUNG_SERGEBNIS]);
        }

        return $transfer;
    }
}
