<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Easycredit;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class EasycreditConfig extends AbstractBundleConfig
{
    public const PROVIDER_NAME = 'Easycredit';
    public const PAYMENT_METHOD = 'easycredit';
    public const PAYMENT_PAGE_INTEGRATION_TYPE = 'PAYMENT_PAGE';

    public const PAYMENT_METHOD_AVAILABLE_COUNTRIES = ['DE'];
    public const PAYMENT_METHOD_MIN_AVAILABLE_MONEY_VALUE = 20000;
    public const PAYMENT_METHOD_MAX_AVAILABLE_MONEY_VALUE = 500000;

    /**
     * @return string
     */
    public function getPaymentPageIntegrationType(): string
    {
        return static::PAYMENT_PAGE_INTEGRATION_TYPE;
    }

    /**
     * @return array
     */
    public function getPaymentMethodAvailableCountries(): array
    {
        return static::PAYMENT_METHOD_AVAILABLE_COUNTRIES;
    }

    /**
     * @return int
     */
    public function getPaymentMethodMinAvailableMoneyValue(): int
    {
        return static::PAYMENT_METHOD_MIN_AVAILABLE_MONEY_VALUE;
    }

    /**
     * @return int
     */
    public function getPaymentMethodMaxAvailableMoneyValue(): int
    {
        return static::PAYMENT_METHOD_MAX_AVAILABLE_MONEY_VALUE;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return static::PAYMENT_METHOD;
    }
}
