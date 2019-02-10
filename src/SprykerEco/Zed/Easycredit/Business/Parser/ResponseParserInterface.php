<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface ResponseParserInterface
{
    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function parseInitializePaymentResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditInitializePaymentResponseTransfer;

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     * @return EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function parsePreContractualInformationAndRedemptionPlanResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     * @return EasycreditOrderConfirmationResponseTransfer
     */
    public function parseOrderConfirmationResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditOrderConfirmationResponseTransfer;

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     * @return EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    public function parseInterestAndTotalSumResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditInterestAndAdjustTotalSumResponseTransfer;

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     * @return EasycreditQueryCreditAssessmentResponseTransfer
     */
    public function parseQueryCreditAssessmentResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditQueryCreditAssessmentResponseTransfer;

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     * @return EasycreditApprovalTextResponseTransfer
     */
    public function parseApprovalTextResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditApprovalTextResponseTransfer;
}
