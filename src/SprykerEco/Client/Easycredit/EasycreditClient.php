<?php

namespace SprykerEco\Client\Easycredit;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerEco\Client\Easycredit\EasycreditFactory getFactory()
 */
class EasycreditClient extends AbstractClient implements EasycreditClientInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitialize(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this->getFactory()->createZedStub()->sendEasycreditPaymentInitialize($quoteTransfer);
    }

    /**
     * @return \SprykerEco\Client\Easycredit\Zed\EasycreditStubInterface
     */
    protected function getZedStub()
    {
        return $this->getFactory()->createZedStub();
    }
}
