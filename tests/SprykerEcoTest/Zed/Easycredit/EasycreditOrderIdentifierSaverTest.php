<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Generated\Shared\Transfer\SaveOrderTransfer;

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
     * @return void
     */
    public function testSaveEasycreditOrderIdentifierForEasycredit(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $idSalesOrder = $this->tester->createOrder($quoteTransfer, 'Easycredit01');

        $saveOrderTransfer = new SaveOrderTransfer();
        $saveOrderTransfer->setIdSalesOrder($idSalesOrder);

        $facade = $this->prepareFacade();
        $easycreditOrderIdentifierTransfer = $facade->saveEasycreditOrderIdentifier($quoteTransfer, $saveOrderTransfer);

        $this->assertEquals($easycreditOrderIdentifierTransfer->getIdentifier(), $quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        $this->assertEquals($easycreditOrderIdentifierTransfer->getFkSalesOrder(), $idSalesOrder);
        $this->assertEquals($easycreditOrderIdentifierTransfer->getConfirmed(), false);
    }
}
