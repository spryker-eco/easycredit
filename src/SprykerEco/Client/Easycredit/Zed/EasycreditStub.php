<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Easycredit\Zed;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Client\Easycredit\Dependency\Client\EasycreditToZedRequestClientInterface;

class EasycreditStub implements EasycreditStubInterface
{
    /**
     * @var \SprykerEco\Client\Easycredit\Dependency\Client\EasycreditToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \SprykerEco\Client\Easycredit\Dependency\Client\EasycreditToZedRequestClientInterface $easycreditToZedRequestClient
     */
    public function __construct(EasycreditToZedRequestClientInterface $easycreditToZedRequestClient)
    {
        $this->zedRequestClient = $easycreditToZedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendInitializePaymentRequest(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this->zedRequestClient->call('/easycredit/gateway/send-initialize-payment-request', $quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer
     */
    public function sendQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryCreditAssessmentResponseTransfer
    {
        return $this->zedRequestClient->call('/easycredit/gateway/send-query-credit-assessment-request', $quoteTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function sendApprovalTextRequest(): EasycreditApprovalTextResponseTransfer
    {
        return $this->zedRequestClient->call('/easycredit/gateway/send-approval-text-request', new QuoteTransfer());
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditInterestAndAdjustTotalSumResponseTransfer
    {
        return $this->zedRequestClient->call('/easycredit/gateway/send-interest-and-total-sum-request', $quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequest(
        QuoteTransfer $quoteTransfer
    ): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer {
        return $this->zedRequestClient->call('/easycredit/gateway/send-pre-contractual-information-and-redemption-plan-request', $quoteTransfer);
    }
}
