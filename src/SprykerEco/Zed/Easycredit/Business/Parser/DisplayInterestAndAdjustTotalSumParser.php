<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;

class DisplayInterestAndAdjustTotalSumParser implements ParserInterface
{
    protected const KEY_RATENPLAN = 'ratenplan';
    protected const KEY_ZINSEN = 'zinsen';
    protected const KEY_ANFALLENDE_ZINSEN = 'anfallendeZinsen';

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_RATENPLAN, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setAnfallendeZinsen($payload[static::KEY_RATENPLAN][static::KEY_ZINSEN][static::KEY_ANFALLENDE_ZINSEN]);
        }

        return $transfer;
    }
}
