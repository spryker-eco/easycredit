<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;

interface ResponseParserInterface
{
    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function parseInitializePaymentResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditInitializePaymentResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function parsePreContractualInformationAndRedemptionPlanResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function parseOrderConfirmationResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditOrderConfirmationResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    public function parseInterestAndTotalSumResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditInterestAndAdjustTotalSumResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer
     */
    public function parseQueryCreditAssessmentResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditQueryCreditAssessmentResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function parseApprovalTextResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditApprovalTextResponseTransfer;
}
