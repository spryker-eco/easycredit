<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\PreContractualInformationAndRedemptionPlanProcessor;

use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface PreContractualInformationAndRedemptionPlanProcessorInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
}
