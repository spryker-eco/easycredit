<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use SprykerEco\Yves\Easycredit\Exception\EasycreditInvalidTransferException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerEco\Yves\Easycredit\EasycreditFactory getFactory()
 */
class EasycreditHandlerPlugin extends AbstractPlugin implements StepHandlerPluginInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $quoteTransfer
     *
     * @throws \SprykerEco\Zed\Easycredit\Business\Exception\EasycreditInvalidTransferException
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addToDataClass(Request $request, AbstractTransfer $quoteTransfer): QuoteTransfer
    {
        if (!$quoteTransfer instanceof QuoteTransfer) {
            throw new EasycreditInvalidTransferException();
        }

        return $this->getFactory()->createEasycreditPaymentHandler()->addPaymentToQuote($quoteTransfer);
    }
}
