<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Communication\Plugin\Payment;

use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Payment\Dependency\Plugin\Payment\PaymentMethodFilterPluginInterface;

/**
 * @method \SprykerEco\Zed\Easycredit\Business\EasycreditFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Easycredit\EasycreditConfig getConfig()
 */
class EasycreditPaymentMethodFilterPlugin extends AbstractPlugin implements PaymentMethodFilterPluginInterface
{
    /**
     * {@inheritDoc}
     * Specification:
     * - Returns filtered by set of plugins array object of payments.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(PaymentMethodsTransfer $paymentMethodsTransfer, QuoteTransfer $quoteTransfer)
    {
        return $this->getFacade()->filterPaymentMethods($paymentMethodsTransfer, $quoteTransfer);
    }
}
