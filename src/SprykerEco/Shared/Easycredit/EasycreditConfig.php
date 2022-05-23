<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\Easycredit;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class EasycreditConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PROVIDER_NAME = 'Easycredit';

    /**
     * @var string
     */
    public const PAYMENT_METHOD = 'easycredit';

    /**
     * @var string
     */
    public const PAYMENT_PAGE_INTEGRATION_TYPE = 'PAYMENT_PAGE';

    /**
     * @var array<string>
     */
    public const PAYMENT_METHOD_AVAILABLE_COUNTRIES = ['DE'];

    /**
     * @var int
     */
    public const PAYMENT_METHOD_MIN_AVAILABLE_MONEY_VALUE = 20000;

    /**
     * @var int
     */
    public const PAYMENT_METHOD_MAX_AVAILABLE_MONEY_VALUE = 1000000;

    /**
     * @api
     *
     * @return string
     */
    public function getPaymentPageIntegrationType(): string
    {
        return static::PAYMENT_PAGE_INTEGRATION_TYPE;
    }

    /**
     * @api
     *
     * @return array<string>
     */
    public function getPaymentMethodAvailableCountries(): array
    {
        return static::PAYMENT_METHOD_AVAILABLE_COUNTRIES;
    }

    /**
     * @api
     *
     * @return int
     */
    public function getPaymentMethodMinAvailableMoneyValue(): int
    {
        return static::PAYMENT_METHOD_MIN_AVAILABLE_MONEY_VALUE;
    }

    /**
     * @api
     *
     * @return int
     */
    public function getPaymentMethodMaxAvailableMoneyValue(): int
    {
        return static::PAYMENT_METHOD_MAX_AVAILABLE_MONEY_VALUE;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return static::PAYMENT_METHOD;
    }
}
