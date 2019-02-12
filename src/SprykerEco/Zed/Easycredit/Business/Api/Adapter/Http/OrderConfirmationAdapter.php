<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Symfony\Component\HttpFoundation\Request;

class OrderConfirmationAdapter extends AbstractAdapter
{
    /**
     * @param \Generated\Shared\Transfer\EasycreditRequestTransfer $requestTransfer
     *
     * @return string
     */
    protected function getUrl(EasycreditRequestTransfer $requestTransfer): string
    {
        return sprintf(
            '%s/%s/%s/%s',
            $this->config->getApiUrl(),
            static::REQUEST_TYPE_PROCESS,
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
