<?php

namespace SprykerEco\Zed\Easycredit\Communication\Controller;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \SprykerEco\Zed\Easycredit\Business\EasycreditFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param QuoteTransfer $transfer
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitializeAction(QuoteTransfer $transfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this
            ->getFacade()
            ->sendPaymentInitializeRequest($transfer);
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditQueryAssessmentResponseTransfer
     */
    public function sendEasycreditQueryAssessmentRequestAction(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer
    {
        return $this
            ->getFacade()
            ->sendQueryCreditAssessmentRequest($quoteTransfer);
    }

    /**
     * @return EasycreditApprovalTextResponseTransfer
     */
    public function getEasycreditApprovalTextAction(): EasycreditApprovalTextResponseTransfer
    {
        return $this
            ->getFacade()
            ->sendGettingApprovalTextRequest();
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndAdjustTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
    {
        return $this->getFacade()->sendInterestAndAdjustTotalSumRequest($quoteTransfer);
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        return $this->getFacade()->sendPreContractualInformationAndRedemptionPlanRequest($quoteTransfer);
    }
}
