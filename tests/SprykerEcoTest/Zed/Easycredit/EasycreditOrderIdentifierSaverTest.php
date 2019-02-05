<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Generated\Shared\Transfer\SaveOrderTransfer;
use SprykerEco\Zed\Easycredit\Business\EasycreditFacade;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManager;

class EasycreditOrderIdentifierSaverTest extends AbstractEasycreditTest
{
    /**
     * @return void
     */
    public function testSaveEasycreditOrderIdentifierForEasycredit(): void
    {
        $quoteTransfer = $this->prepareQuoteTransfer();
        $quoteTransfer->setPayment($this->preparePaymentTransfer());

        $em = $this->createEasycreditEntityManager();


        /** @var EasycreditFacade $facade */
        $facade = $this->prepareFacade();
        $facade->saveEasycreditOrderIdentifier($quoteTransfer, new SaveOrderTransfer());
        $em->expects($this->once())->method('saveEasycreditOrderIdentifier');
    }

    /**
     * @return EasycreditEntityManager
     */
    protected function createEasycreditEntityManager(): EasycreditEntityManager
    {
        $em =  $this->getMockBuilder(EasycreditEntityManager::class)
            ->getMock();

        $em->expects($this->once())->method('saveEasycreditOrderIdentifier');

        return $em;
    }
}
