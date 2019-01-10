<?php

namespace SprykerEco\Shared\Easycredit;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class EasycreditConfig extends AbstractBundleConfig
{
    public const PROVIDER_NAME = 'easycredit';
    public const PAYMENT_METHOD = 'Installments';
    public const PAYMENT_PAGE_INTEGRATION_TYPE = 'PAYMENT_PAGE';

    /**
     * @return string
     */
    public function getPaymentPageIntegrationType(): string
    {
        return static::PAYMENT_PAGE_INTEGRATION_TYPE;
    }
}
