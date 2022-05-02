<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use ArrayObject;
use Generated\Shared\DataBuilder\AddressBuilder;
use Generated\Shared\DataBuilder\CustomerBuilder;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\DataBuilder\ShipmentBuilder;
use Generated\Shared\DataBuilder\TotalsBuilder;

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
    public function testInitializePaymentRequest(): void
    {
        // Arrange
        $quoteTransfer = $this->initializeQuoteTransfer();

        // Act
        $requestTransfer = $this->createMapper()->mapInitializePaymentRequest($quoteTransfer);

        // Assert
        $this->assertEquals($requestTransfer->getPayload()[static::REQUEST_KEY_ORDER_AMOUNT], 15.0);
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function initializeQuoteTransfer(): \Generated\Shared\Transfer\QuoteTransfer
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $itemTransfer = (new ItemBuilder())->build();
        $itemTransfer->setRefundableAmount(123123);
        $test = new ArrayObject();
        $test[] = $itemTransfer;
        $quoteTransfer->setItems((new ArrayObject([$itemTransfer])));

        $totalsTransfer = (new TotalsBuilder())->build();
        $totalsTransfer->setGrandTotal(1500);
        $quoteTransfer->setTotals($totalsTransfer);

        $customerTransfer = (new CustomerBuilder())->build();
        $quoteTransfer->setCustomer($customerTransfer);

        $addressTransfer = (new AddressBuilder())->build();
        $quoteTransfer->setShippingAddress($addressTransfer);
        $quoteTransfer->setBillingAddress($addressTransfer);

        $shipmentTransfer = (new ShipmentBuilder())->build();
        $quoteTransfer->setShipment($shipmentTransfer);

        return $quoteTransfer;

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
