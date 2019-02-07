<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class QueryCreditAssessmentResponseParser implements ParserInterface
{
    protected const KEY_ENTSCHEIDUNG = 'entscheidung';
    protected const KEY_ENTSCHEIDUNG_SERGEBNIS = 'entscheidungsergebnis';

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditQueryAssessmentResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_ENTSCHEIDUNG, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setStatus($payload[static::KEY_ENTSCHEIDUNG][static::KEY_ENTSCHEIDUNG_SERGEBNIS]);
        }

        return $transfer;
    }
}
