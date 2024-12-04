<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Generated\Shared\Transfer\ShipmentCarrierTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\StoreTransfer;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Easycredit
 * @group EasycreditTest
 * @group EasycreditOrderIdentifierSaverTest
 */
class EasycreditOrderIdentifierSaverTest extends AbstractEasycreditTest
{
    /**
     * @var string
     */
    protected const DEFAULT_STORE_NAME = 'DE';

    /**
     * @var string
     */
    protected const DEFAULT_CURRENCY_CODE = 'EUR';

    /**
     * @var string
     */
    protected const DEFAULT_SHIPMENT_METHOD_NAME = 'Standard';

    /**
     * @var string
     */
    protected const TEST_SHIPMENT_CARRIER_NAME = 'test_shipment_carrier';

    /**
     * @return void
     */
    public function testSaveEasycreditOrderIdentifierForEasycredit(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $this->tester->haveStore([StoreTransfer::NAME => static::DEFAULT_STORE_NAME]);
        $this->tester->haveCurrency([CurrencyTransfer::CODE => static::DEFAULT_CURRENCY_CODE]);
        $this->tester->haveShipmentMethod(
            [ShipmentMethodTransfer::NAME => static::DEFAULT_SHIPMENT_METHOD_NAME],
            [ShipmentCarrierTransfer::NAME => static::TEST_SHIPMENT_CARRIER_NAME],
        );

        $idSalesOrder = $this->tester->createOrder();

        $saveOrderTransfer = new SaveOrderTransfer();
        $saveOrderTransfer->setIdSalesOrder($idSalesOrder);

        $facade = $this->prepareFacade();
        $easycreditOrderIdentifierTransfer = $facade->saveEasycreditOrderIdentifier($quoteTransfer, $saveOrderTransfer);

        $this->assertEquals($easycreditOrderIdentifierTransfer->getIdentifier(), $quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        $this->assertEquals($easycreditOrderIdentifierTransfer->getFkSalesOrder(), $idSalesOrder);
        $this->assertEquals($easycreditOrderIdentifierTransfer->getConfirmed(), false);
    }
}
