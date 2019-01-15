<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use GuzzleHttp\ClientInterface;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use Generated\Shared\Transfer\InxmailRequestTransfer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;
use SprykerEco\Zed\Easycredit\Business\Exception\EasycreditApiHttpRequestException;
use SprykerEco\Zed\Easycredit\EasycreditConfig;

abstract class AbstractAdapter implements AdapterInterface
{
    protected const DEFAULT_TIMEOUT = 45;

    protected const API_KEY_EVENT = 'event';
    protected const API_KEY_PAYLOAD = 'payload';
    protected const API_KEY_TRANSACTION_ID = 'transactionId';

    protected const HEADER_TBK_RK_SHOP = 'tbk-rk-shop';
    protected const HEADER_TBK_RK_TOKEN = 'tbk-rk-token';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var EasycreditToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var EasycreditConfig
     */
    protected $config;

    /**
     * @return string
     */
    abstract protected function getUrl(): string;

    public function __construct(
        ClientInterface $client,
        EasycreditToUtilEncodingServiceInterface $utilEncodingService,
        EasycreditConfig $config
    ) {
        $this->client = $client;
        $this->utilEncodingService = $utilEncodingService;
        $this->config = $config;
    }

    /**
     * @param EasycreditRequestTransfer $transfer
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function sendRequest(EasycreditRequestTransfer $transfer): StreamInterface
    {
        $options[RequestOptions::BODY] = $this->utilEncodingService->encodeJson($transfer->getPayload());
        $options[RequestOptions::HEADERS] = $this->getHeaders();

        return $this->send($options);
    }

    /**
     * @param array $options
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function send(array $options = []): StreamInterface
    {
        try {
            $response = $this->client->post(
                $this->getUrl(),
                $options
            );
        } catch (RequestException $requestException) {
            throw new EasycreditApiHttpRequestException(
                $requestException->getMessage(),
                $requestException->getCode(),
                $requestException
            );
        }

        return $response->getBody();
    }

    /**
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            static::HEADER_TBK_RK_SHOP => $this->config->getShopIdentifier(),
            static::HEADER_TBK_RK_TOKEN => $this->config->getShopToken(),
        ];
    }
}
