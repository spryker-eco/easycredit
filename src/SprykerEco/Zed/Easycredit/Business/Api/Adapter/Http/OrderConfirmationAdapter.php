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
    protected const URL_ORDER_COMPLETION_IDENTIFIER = 'bestaetigen';

    /**
     * @param \Generated\Shared\Transfer\EasycreditRequestTransfer $easycreditRequestTransfer
     *
     * @return string
     */
    protected function getUrl(EasycreditRequestTransfer $easycreditRequestTransfer): string
    {
        return sprintf(
            '%s/%s/%s/%s',
            $this->config->getApiUrl(),
            static::REQUEST_TYPE_PROCESS,
            $easycreditRequestTransfer->getVorgangskennung(),
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
