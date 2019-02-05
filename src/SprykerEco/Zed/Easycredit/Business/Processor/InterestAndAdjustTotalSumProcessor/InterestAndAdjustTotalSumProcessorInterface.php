<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\InterestAndAdjustTotalSumProcessor;

use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface InterestAndAdjustTotalSumProcessorInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
}
