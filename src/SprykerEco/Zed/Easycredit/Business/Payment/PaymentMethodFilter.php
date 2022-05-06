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
use SprykerEco\Zed\Easycredit\EasycreditConfig;

class PaymentMethodFilter implements PaymentMethodFilterInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\EasycreditConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Easycredit\EasycreditConfig $config
     */
    public function __construct(EasycreditConfig $config)
    {
        $this->config = $config;
    }

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
        return $quoteTransfer->getTotals()->getGrandTotal() >= $this->config->getPaymentMethodMinAvailableMoneyValue() &&
            $quoteTransfer->getTotals()->getGrandTotal() <= $this->config->getPaymentMethodMaxAvailableMoneyValue() ||
            ($quoteTransfer->getBillingAddress() && in_array($quoteTransfer->getBillingAddress()->getIso2Code(), $this->config->getPaymentMethodAvailableCountries()));
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentMethodTransfer $paymentMethodTransfer
     *
     * @return bool
     */
    protected function isPaymentMethodEasycredit(PaymentMethodTransfer $paymentMethodTransfer): bool
    {
        return strpos($paymentMethodTransfer->getMethodName() ?? '', $this->config->getPaymentMethod()) !== false;
    }
}
