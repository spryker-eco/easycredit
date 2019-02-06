<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Easycredit;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Easycredit
 * @group EasycreditTest
 * @group EasycreditSendRequestTest
 */
class EasycreditSendRequestTest extends AbstractEasycreditTest
{
    /**
     * @return void
     */
    public function testSendPaymentInitializeRequest(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendPaymentInitializeRequest($quoteTransfer);

        $this->assertEquals(static::RESPONSE_KEY_PAYMENT_IDENTIFIER, $responseTransfer->getPaymentIdentifier());
        $this->assertTrue($responseTransfer->getSuccess());
    }

    /**
     * @return void
     */
    public function testSendQueryCreditAssessmentRequest(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendQueryCreditAssessmentRequest($quoteTransfer);

        $this->assertEquals(static::RESPONSE_KEY_STATUS, $responseTransfer->getStatus());
        $this->assertTrue($responseTransfer->getSuccess());
    }

    /**
     * @return void
     */
    public function testSendOrderConfirmationRequest(): void
    {
        $idSalesOrder = $this->tester->createOrder();

        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendOrderConfirmationRequest($idSalesOrder);

        $this->assertTrue($responseTransfer->getSuccess());
        $this->assertFalse($responseTransfer->getConfirmed());
    }

    /**
     * @return void
     */
    public function testSendGettingApprovalTextRequest(): void
    {
        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendGettingApprovalTextRequest();

        $this->assertTrue($responseTransfer->getSuccess());
        $this->assertEquals(static::RESPONSE_KEY_TEXT, $responseTransfer->getText());
    }

    /**
     * @return void
     */
    public function testSendInterestAndAdjustTotalSumRequest(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendInterestAndAdjustTotalSumRequest($quoteTransfer);

        $this->assertTrue($responseTransfer->getSuccess());
        $this->assertEquals(static::RESPONSE_KEY_ANFALLENDE_ZINSEN, $responseTransfer->getAnfallendeZinsen());
    }

    /**
     * @return void
     */
    public function testSendPreContractualInformationAndRedemptionPlanRequest(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendPreContractualInformationAndRedemptionPlanRequest($quoteTransfer);

        $this->assertTrue($responseTransfer->getSuccess());
        $this->assertEquals(static::RESPONSE_KEY_TILGUNGSPLAN_TEXT, $responseTransfer->getTilgungsplanText());
        $this->assertEquals(static::RESPONSE_KEY_URL_VORVERTRAGLICHE_INFORMATIONEN, $responseTransfer->getUrlVorvertraglicheInformationen());
    }
}
