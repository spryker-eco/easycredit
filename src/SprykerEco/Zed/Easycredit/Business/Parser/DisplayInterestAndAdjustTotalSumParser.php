<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class DisplayInterestAndAdjustTotalSumParser implements ParserInterface
{
    protected const KEY_RATENPLAN = 'ratenplan';
    protected const KEY_ZINSEN = 'zinsen';
    protected const KEY_ANFALLENDE_ZINSEN = 'anfallendeZinsen';

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
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
