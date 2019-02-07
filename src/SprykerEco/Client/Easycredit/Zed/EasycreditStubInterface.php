<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Easycredit\Zed;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface EasycreditStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitialize(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer
     */
    public function sendEasycreditQueryAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function getEasycreditApprovalTextAction(): EasycreditApprovalTextResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndAdjustTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
}
