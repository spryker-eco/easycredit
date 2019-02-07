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
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class EasycreditStub extends ZedRequestStub implements EasycreditStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitialize(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this->zedStub->call('/easycredit/gateway/send-easycredit-payment-initialize', $quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer
     */
    public function sendEasycreditQueryAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer
    {
        return $this->zedStub->call('/easycredit/gateway/send-easycredit-query-assessment-request', $quoteTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function getEasycreditApprovalTextAction(): EasycreditApprovalTextResponseTransfer
    {
        return $this->zedStub->call('/easycredit/gateway/get-easycredit-approval-text', new QuoteTransfer());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndAdjustTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
    {
        return $this->zedStub->call('/easycredit/gateway/send-interest-and-adjust-total-sum-request', $quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        return $this->zedStub->call('/easycredit/gateway/send-pre-contractual-information-and-redemption-plan-request', $quoteTransfer);
    }
}
