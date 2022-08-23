<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;

interface EasycreditFacadeInterface
{
    /**
     * Specification:
     * - Send a request to Easycredit for payment initialization.
     * - Requires `QuoteTransfer.totals` parameter to be set.
     * - Requires `QuoteTransfer.customer` parameter to be set.
     * - Requires `QuoteTransfer.shippingAddress` parameter to be set.
     * - Requires `QuoteTransfer.billingAddress` parameter to be set.
     * - Requires `QuoteTransfer.shipment` parameter to be set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendInitializePaymentRequest(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer;

    /**
     * Specification:
     * - Send a request to Easycredit for getting query assessment value.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer
     */
    public function sendQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryCreditAssessmentResponseTransfer;

    /**
     * Specification:
     * - Send a request to Easycredit for confirmation order. It can be used in order state machine command.
     *
     * @api
     *
     * @param int $orderId
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function sendOrderConfirmationRequest(int $orderId): EasycreditOrderConfirmationResponseTransfer;

    /**
     * Specification:
     * - Send a request to Easycredit for getting approval text to showing to a user.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function sendApprovalTextRequest(): EasycreditApprovalTextResponseTransfer;

    /**
     * Specification:
     * - Send a request to Easycredit for getting Easycredit interest for the order.
     * - Requires `QuoteTransfer.payment.easycredit` parameter to be set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditInterestAndAdjustTotalSumResponseTransfer;

    /**
     * Specification:
     * - Send a request to Easycredit for getting pre-contractual link and redemption plan text for order.
     * - Requires `QuoteTransfer.payment.easycredit` parameter to be set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequest(
        QuoteTransfer $quoteTransfer
    ): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;

    /**
     * Specification:
     * - Filter array object of payments by set of plugins.
     * - Requires `QuoteTransfer.totals` parameter to be set.
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
     * Specification:
     * - Save order identifier for new order. It can be used in CheckoutDoSaveOrderInterface plugins.
     * - Requires `QuoteTransfer.payment.easycredit` parameter to be set.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function saveEasycreditOrderIdentifier(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): PaymentEasycreditOrderIdentifierTransfer;
}
