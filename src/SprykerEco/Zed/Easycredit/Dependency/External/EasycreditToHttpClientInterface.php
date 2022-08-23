<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Dependency\External;

interface EasycreditToHttpClientInterface
{
    /**
     * @param string $method
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return \SprykerEco\Zed\Easycredit\Dependency\External\EasycreditToHttpResponseInterface
     */
    public function request(string $method, string $uri, array $options = []): EasycreditToHttpResponseInterface;
}
