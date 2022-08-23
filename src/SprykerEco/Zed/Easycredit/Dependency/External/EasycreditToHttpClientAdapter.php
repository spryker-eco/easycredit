<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Dependency\External;

use GuzzleHttp\Client;

class EasycreditToHttpClientAdapter implements EasycreditToHttpClientInterface
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array<string, mixed> $options
     *
     * @return \SprykerEco\Zed\Easycredit\Dependency\External\EasycreditToHttpResponseInterface
     */
    public function request(string $method, string $uri, array $options = []): EasycreditToHttpResponseInterface
    {
        $response = $this->client->request($method, $uri, $options);

        return new EasycreditToHttpResponseAdapter($response);
    }
}
