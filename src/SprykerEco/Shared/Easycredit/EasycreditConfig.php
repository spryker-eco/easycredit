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

    /**
     * @return string
     */
    public function getPaymentPageIntegrationType(): string
    {
        return static::PAYMENT_PAGE_INTEGRATION_TYPE;
    }
}
