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
        // Arrange
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());
        $facade = $this->prepareFacade();

        // Act
        $responseTransfer = $facade->sendInitializePaymentRequest($quoteTransfer);

        // Assert
        $this->assertEquals(static::RESPONSE_KEY_PAYMENT_IDENTIFIER, $responseTransfer->getPaymentIdentifier());
        $this->assertTrue($responseTransfer->getSuccess());
    }

    /**
     * @return void
     */
    public function testInitializePaymentRequestOnConvertingAmountFromIntegerToFloatValue(): void
    {
        // Arrange
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());
        $quoteTransfer->setItems($this->prepareItemTransfers());
        $quoteTransfer->setTotals($this->prepareTotalsTransfer(1500));
        $quoteTransfer->setCustomer($this->prepareCustomerTransfer());
        $quoteTransfer->setShippingAddress($this->prepareAddressTransfer());
        $quoteTransfer->setBillingAddress($this->prepareAddressTransfer());
        $quoteTransfer->setShipment($this->prepareShipmentTransfer());

        // Act
        $requestTransfer = $this->createMapper()->mapInitializePaymentRequest($quoteTransfer);

        // Assert
        $this->assertEquals($requestTransfer->getPayload()[static::REQUEST_KEY_ORDER_AMOUNT], 15.0);
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
        $quoteTransfer = $this->prepareQuoteTransfer();
        $idSalesOrder = $this->tester->createOrder($quoteTransfer);

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
