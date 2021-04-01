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
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapInitializePaymentRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @param int $fkSalesOrder
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapOrderConfirmationRequest(
        int $fkSalesOrder,
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
    ): EasycreditRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapInterestAndTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer;

    /**
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapApprovalTextRequest(): EasycreditRequestTransfer;
}
