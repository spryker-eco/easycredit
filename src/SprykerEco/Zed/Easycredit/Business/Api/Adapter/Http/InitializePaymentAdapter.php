<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Symfony\Component\HttpFoundation\Request;

class InitializePaymentAdapter extends AbstractAdapter
{
    /**
     * @param EasycreditRequestTransfer $requestTransfer
     *
     * @return string
     */
    protected function getUrl(EasycreditRequestTransfer $requestTransfer): string
    {
        return sprintf('%s/%s/', $this->config->getApiUrl(), static::REQUEST_TYPE_PROCESS);
    }

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return Request::METHOD_POST;
    }
}