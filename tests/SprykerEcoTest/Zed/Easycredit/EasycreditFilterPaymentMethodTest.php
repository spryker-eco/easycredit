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
 * @group EasycreditFilterPaymentMethodTest
 */
class EasycreditFilterPaymentMethodTest extends AbstractEasycreditTest
{
    /**
     * @return void
     */
    public function testEasycreditMethodIsLeftAfterFilter(): void
    {
        $facade = $this->prepareFacade();

        $quoteTransfer = $this->prepareQuoteTransfer();
        $paymentMethodsTransfer = $this->preparePaymentMethodsTransfer();

        $quoteTransfer->setTotals($this->prepareTotalsTransfer(20000));

        $paymentMethodsTransfer = $facade->filterPaymentMethods($paymentMethodsTransfer, $quoteTransfer);

        $this->assertEquals(count($paymentMethodsTransfer->getMethods()), 1);
    }

    /**
     * @return void
     */
    public function testEasycreditMethodIsNotLeftAfterFilter(): void
    {
        $facade = $this->prepareFacade();

        $quoteTransfer = $this->prepareQuoteTransfer();
        $paymentMethodsTransfer = $this->preparePaymentMethodsTransfer();

        $quoteTransfer->setTotals($this->prepareTotalsTransfer(200));

        $paymentMethodsTransfer = $facade->filterPaymentMethods($paymentMethodsTransfer, $quoteTransfer);

        $this->assertEquals(count($paymentMethodsTransfer->getMethods()), 0);
    }
}
