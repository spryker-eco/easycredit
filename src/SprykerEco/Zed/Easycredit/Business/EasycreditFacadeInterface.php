<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface EasycreditFacadeInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function sendPaymentInitializeRequest(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer;

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditQueryAssessmentResponseTransfer
     */
    public function sendQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer;

    /**
     * @param int EasycreditOrderConfirmationResponseTransfer
     *
     * @return EasycreditOrderConfirmationResponseTransfer
     */
    public function sendOrderConfirmationRequest(int $orderId): EasycreditOrderConfirmationResponseTransfer;

    /**
     * @return EasycreditApprovalTextResponseTransfer
     */
    public function sendGettingApprovalTextRequest(): EasycreditApprovalTextResponseTransfer;

    /**
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(PaymentMethodsTransfer $paymentMethodsTransfer, QuoteTransfer $quoteTransfer): PaymentMethodsTransfer;

    /**
     * @param QuoteTransfer $quoteTransfer
     * @param SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveEasycreditOrderIdentifier(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): void;
}
