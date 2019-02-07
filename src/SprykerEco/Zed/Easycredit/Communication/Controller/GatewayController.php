<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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
     * @param \Generated\Shared\Transfer\QuoteTransfer $transfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitializeAction(QuoteTransfer $transfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this
            ->getFacade()
            ->sendPaymentInitializeRequest($transfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer
     */
    public function sendEasycreditQueryAssessmentRequestAction(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer
    {
        return $this
            ->getFacade()
            ->sendQueryCreditAssessmentRequest($quoteTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function getEasycreditApprovalTextAction(): EasycreditApprovalTextResponseTransfer
    {
        return $this
            ->getFacade()
            ->sendGettingApprovalTextRequest();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndAdjustTotalSumRequestAction(QuoteTransfer $quoteTransfer): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
    {
        return $this->getFacade()->sendInterestAndAdjustTotalSumRequest($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequestAction(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        return $this->getFacade()->sendPreContractualInformationAndRedemptionPlanRequest($quoteTransfer);
    }
}
