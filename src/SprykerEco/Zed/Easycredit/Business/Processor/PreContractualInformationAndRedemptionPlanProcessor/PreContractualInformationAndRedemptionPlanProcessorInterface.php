<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\PreContractualInformationAndRedemptionPlanProcessor;

use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface PreContractualInformationAndRedemptionPlanProcessorInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
}
