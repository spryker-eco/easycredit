<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Payment;

use ArrayObject;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;

class PaymentMethodFilter implements PaymentMethodFilterInterface
{
    protected const AVAILABLE_COUNTRIES = ['DE'];

    protected const MIN_AVAILABLE_MONEY_VALUE = 20000;
    protected const MAX_AVAILABLE_MONEY_VALUE = 500000;

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(PaymentMethodsTransfer $paymentMethodsTransfer, QuoteTransfer $quoteTransfer): PaymentMethodsTransfer
    {
        $result = new ArrayObject();

        foreach ($paymentMethodsTransfer->getMethods() as $paymentMethod) {
            if ($this->isPaymentMethodEasycredit($paymentMethod) && !$this->isAvailable($quoteTransfer)) {
                continue;
            }
            $result->append($paymentMethod);
        }

        $paymentMethodsTransfer->setMethods($result);

        return $paymentMethodsTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isAvailable(QuoteTransfer $quoteTransfer): bool
    {
        return $quoteTransfer->getTotals()->getGrandTotal() >= static::MIN_AVAILABLE_MONEY_VALUE &&
            $quoteTransfer->getTotals()->getGrandTotal() <= static::MAX_AVAILABLE_MONEY_VALUE ||
            in_array($quoteTransfer->getBillingAddress(), static::AVAILABLE_COUNTRIES);
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return bool
     */
    protected function isPaymentMethodEasycredit(PaymentMethodTransfer $paymentMethodTransfer): bool
    {
        return strpos($paymentMethodTransfer->getMethodName(), EasycreditConfig::PAYMENT_METHOD) !== false;
    }
}
