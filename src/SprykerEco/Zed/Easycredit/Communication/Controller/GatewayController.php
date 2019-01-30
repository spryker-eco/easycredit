<?php

namespace SprykerEco\Zed\Easycredit\Communication\Controller;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
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
}
