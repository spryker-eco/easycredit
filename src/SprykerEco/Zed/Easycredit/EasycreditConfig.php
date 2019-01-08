<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Easycredit\EasycreditConstants;

class EasycreditConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getSuccessUrl(): string
    {
        return $this->get(EasycreditConstants::SUCCESS_URL);
    }

    /**
     * @return string
     */
    public function getCancelledUrl(): string
    {
        return $this->get(EasycreditConstants::CANCELLED_URL);
    }

    /**
     * @return string
     */
    public function getDeniedUrl(): string
    {
        return $this->get(EasycreditConstants::DENIED_URL);
    }
}
