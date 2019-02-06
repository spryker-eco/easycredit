<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return AbstractTransfer
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
