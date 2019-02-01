<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;
use SprykerEco\Zed\Easycredit\Business\EasycreditBusinessFactory;
use SprykerEco\Zed\Easycredit\Business\EasycreditFacade;
use SprykerEco\Zed\Easycredit\Business\EasycreditFacadeInterface;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Easycredit
 * @group EasycreditTest
 */
abstract class AbstractEasycreditTest extends Unit
{
    /**
     * @return \SprykerEco\Zed\Easycredit\Business\EasycreditFacadeInterface
     */
    protected function prepareFacade(): EasycreditFacadeInterface
    {
        $facade = new EasycreditFacade();
        $facade->setFactory($this->createEasycreditBusinessFactoryMock());

        return $facade;
    }

    /**
     * @return EasycreditBusinessFactory
     */
    protected function createEasycreditBusinessFactoryMock(): EasycreditBusinessFactory
    {
        $factory = $this->getMockBuilder(EasycreditBusinessFactory::class)
            ->setMethodsExcept([
                'createPaymentMethodFilter',
            ])
            ->getMock();

        return $factory;
    }

    /**
     * @return QuoteTransfer
     */
    protected function prepareQuoteTransfer(): QuoteTransfer
    {
        $quoteTransfer = new QuoteTransfer();

        return $quoteTransfer;
    }

    /**
     * @return PaymentMethodsTransfer
     */
    protected function preparePaymentMethodsTransfer(): PaymentMethodsTransfer
    {
        $paymentMethodTransfer = new PaymentMethodTransfer();
        $paymentMethodTransfer->setMethodName(EasycreditConfig::PAYMENT_METHOD);

        $paymentMethodsTransfer = new PaymentMethodsTransfer();
        $paymentMethodsTransfer->addMethod($paymentMethodTransfer);

        return $paymentMethodsTransfer;
    }

    /**
     * @param int $grandTotal
     *
     * @return TotalsTransfer
     */
    protected function prepareTotalsTransfer(int $grandTotal): TotalsTransfer
    {
        $totalsTransfer = new TotalsTransfer();
        $totalsTransfer->setGrandTotal($grandTotal);

        return $totalsTransfer;
    }
}
