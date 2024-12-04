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

class ResponseParser implements ResponseParserInterface
{
    /**
     * @var string
     */
    protected const KEY_PAYMENT_IDENTIFIER = 'tbVorgangskennung';

    /**
     * @var string
     */
    protected const KEY_ALLGEMEINE_VORGANGSDATEN = 'allgemeineVorgangsdaten';

    /**
     * @var string
     */
    protected const KEY_URL_VORVERTRAGLICHE_INFORMATIONEN = 'urlVorvertraglicheInformationen';

    /**
     * @var string
     */
    protected const KEY_TILGUNGSPLAN_TEXT = 'tilgungsplanText';

    /**
     * @var string
     */
    protected const KEY_WS_MESSAGES = 'wsMessages';

    /**
     * @var string
     */
    protected const KEY_MESSAGES = 'messages';

    /**
     * @var string
     */
    protected const KEY_KEY = 'key';

    /**
     * @var string
     */
    protected const VALUE_SUCCESS_CONFIRMATION = 'BestellungBestaetigenServiceActivity.Infos.ERFOLGREICH';

    /**
     * @var string
     */
    protected const KEY_RATENPLAN = 'ratenplan';

    /**
     * @var string
     */
    protected const KEY_ZINSEN = 'zinsen';

    /**
     * @var string
     */
    protected const KEY_ANFALLENDE_ZINSEN = 'anfallendeZinsen';

    /**
     * @var string
     */
    protected const KEY_ENTSCHEIDUNG = 'entscheidung';

    /**
     * @var string
     */
    protected const KEY_ENTSCHEIDUNG_SERGEBNIS = 'entscheidungsergebnis';

    /**
     * @var string
     */
    protected const KEY_TEXT_IDENTIFIER = 'zustimmungDatenuebertragungPaymentPage';

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function parseInitializePaymentResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditInitializePaymentResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $easycreditInitializePaymentResponseTransfer = new EasycreditInitializePaymentResponseTransfer();
        $easycreditInitializePaymentResponseTransfer->setSuccess(false);

        if ($easycreditResponseTransfer->getError() !== null) {
            return $easycreditInitializePaymentResponseTransfer;
        }

        if (isset($payload[static::KEY_PAYMENT_IDENTIFIER])) {
            $easycreditInitializePaymentResponseTransfer->setPaymentIdentifier($payload[static::KEY_PAYMENT_IDENTIFIER]);
            $easycreditInitializePaymentResponseTransfer->setSuccess(true);
        }

        return $easycreditInitializePaymentResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function parsePreContractualInformationAndRedemptionPlanResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer {
        $payload = $easycreditResponseTransfer->getBody();

        $easycreditPreContractualInformationAndRedemptionPlanResponseTransfer = new EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer();
        $easycreditPreContractualInformationAndRedemptionPlanResponseTransfer->setSuccess(false);

        if ($easycreditResponseTransfer->getError() !== null) {
            return $easycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
        }

        $urlVorvertraglicheInformationen = $payload[static::KEY_ALLGEMEINE_VORGANGSDATEN][static::KEY_URL_VORVERTRAGLICHE_INFORMATIONEN] ?? null;
        $easycreditPreContractualInformationAndRedemptionPlanResponseTransfer->setUrlVorvertraglicheInformationen($urlVorvertraglicheInformationen);
        $easycreditPreContractualInformationAndRedemptionPlanResponseTransfer->setSuccess($urlVorvertraglicheInformationen !== null);

        return $easycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function parseOrderConfirmationResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditOrderConfirmationResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $easycreditOrderConfirmationResponseTransfer = new EasycreditOrderConfirmationResponseTransfer();
        $easycreditOrderConfirmationResponseTransfer->setSuccess(false);

        if ($easycreditResponseTransfer->getError() !== null) {
            return $easycreditOrderConfirmationResponseTransfer;
        }

        $successIdentifier = $payload[static::KEY_WS_MESSAGES][static::KEY_MESSAGES][0][static::KEY_KEY] ?? null;

        $isSuccess = $successIdentifier === static::VALUE_SUCCESS_CONFIRMATION;
        $easycreditOrderConfirmationResponseTransfer->setConfirmed($isSuccess);
        $easycreditOrderConfirmationResponseTransfer->setSuccess($isSuccess);

        return $easycreditOrderConfirmationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    public function parseInterestAndTotalSumResponse(
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): EasycreditInterestAndAdjustTotalSumResponseTransfer {
        $payload = $easycreditResponseTransfer->getBody();

        $easycreditInterestAndAdjustTotalSumResponseTransfer = new EasycreditInterestAndAdjustTotalSumResponseTransfer();
        $easycreditInterestAndAdjustTotalSumResponseTransfer->setSuccess(false);

        if ($easycreditResponseTransfer->getError() !== null) {
            return $easycreditInterestAndAdjustTotalSumResponseTransfer;
        }

        $anfallendeZinsen = isset($payload[static::KEY_RATENPLAN][static::KEY_ZINSEN][static::KEY_ANFALLENDE_ZINSEN]) ?
            (float)$payload[static::KEY_RATENPLAN][static::KEY_ZINSEN][static::KEY_ANFALLENDE_ZINSEN] : null;
        $tilgungsplanText = $payload[static::KEY_TILGUNGSPLAN_TEXT] ?? null;

        $easycreditInterestAndAdjustTotalSumResponseTransfer->setAnfallendeZinsen($anfallendeZinsen);
        $easycreditInterestAndAdjustTotalSumResponseTransfer->setTilgungsplanText($tilgungsplanText);

        $isSuccess = $anfallendeZinsen !== null && $tilgungsplanText !== null;
        $easycreditInterestAndAdjustTotalSumResponseTransfer->setSuccess($isSuccess);

        return $easycreditInterestAndAdjustTotalSumResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer
     */
    public function parseQueryCreditAssessmentResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditQueryCreditAssessmentResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $easycreditQueryCreditAssessmentResponseTransfer = new EasycreditQueryCreditAssessmentResponseTransfer();
        $easycreditQueryCreditAssessmentResponseTransfer->setSuccess(false);

        if ($easycreditResponseTransfer->getError() !== null) {
            return $easycreditQueryCreditAssessmentResponseTransfer;
        }

        $status = $payload[static::KEY_ENTSCHEIDUNG][static::KEY_ENTSCHEIDUNG_SERGEBNIS] ?? null;

        $easycreditQueryCreditAssessmentResponseTransfer->setStatus($status);
        $easycreditQueryCreditAssessmentResponseTransfer->setSuccess($status !== null);

        return $easycreditQueryCreditAssessmentResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function parseApprovalTextResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditApprovalTextResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $easycreditApprovalTextResponseTransfer = new EasycreditApprovalTextResponseTransfer();
        $easycreditApprovalTextResponseTransfer->setSuccess(false);

        if ($easycreditResponseTransfer->getError() !== null) {
            return $easycreditApprovalTextResponseTransfer;
        }

        if (isset($payload[static::KEY_TEXT_IDENTIFIER])) {
            $easycreditApprovalTextResponseTransfer->setSuccess(true);
            $easycreditApprovalTextResponseTransfer->setText($payload[static::KEY_TEXT_IDENTIFIER]);
        }

        return $easycreditApprovalTextResponseTransfer;
    }
}
