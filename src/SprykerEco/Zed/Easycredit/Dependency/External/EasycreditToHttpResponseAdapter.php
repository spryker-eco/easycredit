<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Dependency\External;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class EasycreditToHttpResponseAdapter implements EasycreditToHttpResponseInterface
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getBody(): StreamInterface
    {
        return $this->response->getBody();
    }
}
