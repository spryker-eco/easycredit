<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @group test
     *
     * @return void
     */
    public function testSendInitializePaymentRequest(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendInitializePaymentRequest($quoteTransfer);

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
    public function testSendApprovalTextRequest(): void
    {
        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendApprovalTextRequest();

        $this->assertTrue($responseTransfer->getSuccess());
        $this->assertEquals(static::RESPONSE_KEY_TEXT, $responseTransfer->getText());
    }

    /**
     * @return void
     */
    public function testSendInterestAndTotalSumRequest(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $facade = $this->prepareFacade();
        $responseTransfer = $facade->sendInterestAndTotalSumRequest($quoteTransfer);

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
        $this->assertEquals(static::RESPONSE_KEY_URL_VORVERTRAGLICHE_INFORMATIONEN, $responseTransfer->getUrlVorvertraglicheInformationen());
    }
}
