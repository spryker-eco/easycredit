<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Mapper;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface MapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return EasycreditRequestTransfer
     */
    public function mapInitializePaymentRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return EasycreditRequestTransfer
     */
    public function mapPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @param int $fkSalesOrder
     *
     * @param PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     * @return EasycreditRequestTransfer
     */
    public function mapOrderConfirmationRequest(int $fkSalesOrder, PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer): EasycreditRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return EasycreditRequestTransfer
     */
    public function mapInterestAndTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return EasycreditRequestTransfer
     */
    public function mapQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @return EasycreditRequestTransfer
     */
    public function mapApprovalTextRequest(): EasycreditRequestTransfer;
}
