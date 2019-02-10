<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Symfony\Component\HttpFoundation\Request;

class ApprovalTextAdapter extends AbstractAdapter
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
            static::REQUEST_TYPE_TEXT,
            static::URL_APPROVAL_TEXT_IDENTIFIER,
            $this->config->getShopIdentifier()
        );
    }

    /**
     * @return string
     */
    protected function getMethod(): string
    {
        return Request::METHOD_GET;
    }
}
