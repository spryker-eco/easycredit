<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Symfony\Component\HttpFoundation\Request;

class OrderCompletionAdapter extends AbstractAdapter
{
    /**
     * @param EasycreditRequestTransfer $requestTransfer
     *
     * @return string
     */
    protected function getUrl(EasycreditRequestTransfer $requestTransfer): string
    {
        return sprintf('%s/%s/%s',
            $this->config->getApiUrl(),
            $requestTransfer->getVorgangskennung(),
            static::URL_ORDER_COMPLETION_IDENTIFIER
        );
    }

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return Request::METHOD_POST;
    }
}
