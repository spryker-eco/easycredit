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
    protected const KEY_PAYMENT_IDENTIFIER = 'tbVorgangskennung';
    protected const KEY_ALLGEMEINE_VORGANGSDATEN = 'allgemeineVorgangsdaten';
    protected const KEY_URL_VORVERTRAGLICHE_INFORMATIONEN = 'urlVorvertraglicheInformationen';
    protected const KEY_TILGUNGSPLAN_TEXT = 'tilgungsplanText';
    protected const KEY_WS_MESSAGES = 'wsMessages';
    protected const KEY_MESSAGES = 'messages';
    protected const KEY_KEY = 'key';
    protected const VALUE_SUCCESS_CONFIRMATION = 'BestellungBestaetigenServiceActivity.Infos.ERFOLGREICH';
    protected const KEY_RATENPLAN = 'ratenplan';
    protected const KEY_ZINSEN = 'zinsen';
    protected const KEY_ANFALLENDE_ZINSEN = 'anfallendeZinsen';
    protected const KEY_ENTSCHEIDUNG = 'entscheidung';
    protected const KEY_ENTSCHEIDUNG_SERGEBNIS = 'entscheidungsergebnis';
    protected const KEY_TEXT_IDENTIFIER = 'zustimmungDatenuebertragungPaymentPage';

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function parseInitializePaymentResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditInitializePaymentResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditInitializePaymentResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_PAYMENT_IDENTIFIER, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setPaymentIdentifier($payload[static::KEY_PAYMENT_IDENTIFIER]);
            $transfer->setSuccess(true);
        }

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function parsePreContractualInformationAndRedemptionPlanResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_ALLGEMEINE_VORGANGSDATEN, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setUrlVorvertraglicheInformationen(
                $payload[static::KEY_ALLGEMEINE_VORGANGSDATEN][static::KEY_URL_VORVERTRAGLICHE_INFORMATIONEN]
            );
        }

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function parseOrderConfirmationResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditOrderConfirmationResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditOrderConfirmationResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_WS_MESSAGES, $payload) && !$easycreditResponseTransfer->getError()) {
            if (array_key_exists(static::KEY_MESSAGES, $payload[static::KEY_WS_MESSAGES])) {
                $transfer->setConfirmed($payload[static::KEY_WS_MESSAGES][static::KEY_MESSAGES][0][static::KEY_KEY]
                == static::VALUE_SUCCESS_CONFIRMATION ? true : false);
                $transfer->setSuccess(true);
            }
        }

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    public function parseInterestAndTotalSumResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditInterestAndAdjustTotalSumResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditInterestAndAdjustTotalSumResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_RATENPLAN, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setAnfallendeZinsen($payload[static::KEY_RATENPLAN][static::KEY_ZINSEN][static::KEY_ANFALLENDE_ZINSEN]);
            $transfer->setTilgungsplanText($payload[static::KEY_TILGUNGSPLAN_TEXT]);
        }

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer
     */
    public function parseQueryCreditAssessmentResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditQueryCreditAssessmentResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditQueryCreditAssessmentResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_ENTSCHEIDUNG, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setStatus($payload[static::KEY_ENTSCHEIDUNG][static::KEY_ENTSCHEIDUNG_SERGEBNIS]);
        }

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function parseApprovalTextResponse(EasycreditResponseTransfer $easycreditResponseTransfer): EasycreditApprovalTextResponseTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditApprovalTextResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_TEXT_IDENTIFIER, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setText($payload[static::KEY_TEXT_IDENTIFIER]);
        }

        return $transfer;
    }
}
