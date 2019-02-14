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

        $quoteTransfer->setTotals($this->prepareTotalsTransfer(static::TOTAL_VALUE_FOR_NOT_FILTERED_EASYCREDIT_PAYMENT_METHOD));

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

        $quoteTransfer->setTotals($this->prepareTotalsTransfer(static::TOTAL_VALUE_FOR_FILTERED_EASYCREDIT_PAYMENT_METHOD));

        $paymentMethodsTransfer = $facade->filterPaymentMethods($paymentMethodsTransfer, $quoteTransfer);

        $this->assertEquals(count($paymentMethodsTransfer->getMethods()), 0);
    }
}
