<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EasycreditTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;
use SprykerEco\Zed\Easycredit\Business\EasycreditBusinessFactory;
use SprykerEco\Zed\Easycredit\Business\EasycreditFacade;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManager;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Easycredit
 * @group EasycreditTest
 */
abstract class AbstractEasycreditTest extends Unit
{
    /**
     * @var EasycreditTester
     */
    protected $tester;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\EasycreditFacade
     */
    protected function prepareFacade(): EasycreditFacade
    {
        $facade = $this->tester->getFacade();
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
                'createEasycreditOrderIdentifierSaver',
            ])
            ->setMethods([
                'getEntityManager',
            ])
            ->getMock();

        $factory->method('getEntityManager')->willReturn(new EasycreditEntityManager());

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

    protected function preparePaymentTransfer(): PaymentTransfer
    {
        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentSelection(EasycreditConfig::PAYMENT_METHOD);
        $paymentTransfer->setEasycredit(
            (new EasycreditTransfer())
                ->setVorgangskennung('vorgangskennung')
        );

        return $paymentTransfer;
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
