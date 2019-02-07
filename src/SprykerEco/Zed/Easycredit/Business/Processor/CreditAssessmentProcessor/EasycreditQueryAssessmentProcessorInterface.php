<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor;

use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface EasycreditQueryAssessmentProcessorInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer;
}
