<?php

namespace SprykerEco\Zed\Easycredit\Communication\Controller;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \SprykerEco\Zed\Easycredit\Business\EasycreditFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    public function sendEasycreditPaymentInitializeAction(QuoteTransfer $transfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this
            ->getFacade()
            ->sendPaymentInitializeRequest($transfer);
    }
}
