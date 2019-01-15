<?php

namespace SprykerEco\Client\Easycredit;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface EasycreditClientInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitialize(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer;
}
