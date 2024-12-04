<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Dependency\External;

use Psr\Http\Message\StreamInterface;

interface EasycreditToHttpResponseInterface
{
    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getBody(): StreamInterface;
}
