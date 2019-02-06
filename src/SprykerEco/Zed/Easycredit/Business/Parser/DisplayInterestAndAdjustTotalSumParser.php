<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;

class DisplayInterestAndAdjustTotalSumParser implements ParserInterface
{
    protected const KEY_RATENPLAN = 'ratenplan';
    protected const KEY_ZINSEN = 'zinsen';
    protected const KEY_ANFALLENDE_ZINSEN = 'anfallendeZinsen';

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

        $transfer = new EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer();

        if (array_key_exists(static::KEY_RATENPLAN, $payload)) {
            $transfer->setAnfallendeZinsen($payload[static::KEY_RATENPLAN][static::KEY_ZINSEN][static::KEY_ANFALLENDE_ZINSEN]);
        }

        return $transfer;
    }
}
