<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\EasycreditResponseErrorTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface;
use SprykerEco\Zed\Easycredit\EasycreditConfig;

abstract class AbstractAdapter implements EasycreditAdapterInterface
{
    protected const API_KEY_EVENT = 'event';
    protected const API_KEY_PAYLOAD = 'payload';
    protected const API_KEY_TRANSACTION_ID = 'transactionId';

    protected const HEADER_TBK_RK_SHOP = 'tbk-rk-shop';
    protected const HEADER_TBK_RK_TOKEN = 'tbk-rk-token';
    protected const HEADER_CONTENT_TYPE = 'Content-Type';
    protected const CONTENT_TYPE_JSON = 'application/json';

    protected const REQUEST_TYPE_TEXT = 'texte';
    protected const REQUEST_TYPE_PROCESS = 'vorgang';

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * @var \SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \SprykerEco\Zed\Easycredit\EasycreditConfig
     */
    protected $config;

    /**
     * @param \Generated\Shared\Transfer\EasycreditRequestTransfer $easycreditRequestTransfer
     *
     * @return string
     */
    abstract protected function getUrl(EasycreditRequestTransfer $easycreditRequestTransfer): string;

    /**
     * @return string
     */
    abstract protected function getMethod(): string;

    /**
     * @param \GuzzleHttp\ClientInterface $client
     * @param \SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface $utilEncodingService
     * @param \SprykerEco\Zed\Easycredit\EasycreditConfig $config
     */
    public function __construct(
        ClientInterface $client,
        EasycreditToUtilEncodingServiceInterface $utilEncodingService,
        EasycreditConfig $config
    ) {
        $this->httpClient = $client;
        $this->utilEncodingService = $utilEncodingService;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\EasycreditRequestTransfer $easycreditRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditResponseTransfer
     */
    public function sendRequest(EasycreditRequestTransfer $easycreditRequestTransfer): EasycreditResponseTransfer
    {
        $url = $this->getUrl($easycreditRequestTransfer);
        $method = $this->getMethod();
        $options[RequestOptions::BODY] = $this->utilEncodingService->encodeJson($easycreditRequestTransfer->getPayload());
        $options[RequestOptions::HEADERS] = $this->getHeaders();

        return $this->send($method, $url, $options);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\EasycreditResponseTransfer
     */
    protected function send(string $method, string $url, array $options = []): EasycreditResponseTransfer
    {
        $responseTransfer = new EasycreditResponseTransfer();

        try {
            $response = $this->httpClient->request($method, $url, $options);
            $responseTransfer->setBody($this->utilEncodingService->decodeJson($response->getBody(), true));
        } catch (RequestException $requestException) {
            $errorTransfer = new EasycreditResponseErrorTransfer();
            $errorTransfer->setErrorCode($requestException->getCode());
            $errorTransfer->setErrorMessage($requestException->getMessage());

            $responseTransfer->setError($errorTransfer);
        }

        return $responseTransfer;
    }

    /**
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            static::HEADER_CONTENT_TYPE => static::CONTENT_TYPE_JSON,
            static::HEADER_TBK_RK_SHOP => $this->config->getShopIdentifier(),
            static::HEADER_TBK_RK_TOKEN => $this->config->getShopToken(),
        ];
    }
}
