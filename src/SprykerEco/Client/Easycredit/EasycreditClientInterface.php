<?php

namespace SprykerEco\Client\Easycredit;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;

interface EasycreditClientInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitialize(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer;
}
