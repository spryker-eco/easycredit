<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Easycredit\EasycreditConstants;

/**
 * @method \SprykerEco\Shared\Easycredit\EasycreditConfig getSharedConfig()
 */
class EasycreditConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @return string
     */
    public function getSuccessUrl(): string
    {
        return $this->get(EasycreditConstants::SUCCESS_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getCancelledUrl(): string
    {
        return $this->get(EasycreditConstants::CANCELLED_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getDeniedUrl(): string
    {
        return $this->get(EasycreditConstants::DENIED_URL);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getShopIdentifier(): string
    {
        return $this->get(EasycreditConstants::SHOP_IDENTIFIER);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getShopToken(): string
    {
        return $this->get(EasycreditConstants::SHOP_TOKEN);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPaymentPageIntegrationType(): string
    {
        return $this->getSharedConfig()->getPaymentPageIntegrationType();
    }

    /**
     * @api
     *
     * @return int
     */
    public function getPaymentMethodMinAvailableMoneyValue(): int
    {
        return $this->getSharedConfig()->getPaymentMethodMinAvailableMoneyValue();
    }

    /**
     * @api
     *
     * @return int
     */
    public function getPaymentMethodMaxAvailableMoneyValue(): int
    {
        return $this->getSharedConfig()->getPaymentMethodMaxAvailableMoneyValue();
    }

    /**
     * @api
     *
     * @return array
     */
    public function getPaymentMethodAvailableCountries(): array
    {
        return $this->getSharedConfig()->getPaymentMethodAvailableCountries();
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->getSharedConfig()->getPaymentMethod();
    }

    /**
     * @api
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->get(EasycreditConstants::API_URL);
    }
}
