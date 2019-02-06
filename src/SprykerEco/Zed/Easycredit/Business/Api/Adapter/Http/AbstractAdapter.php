<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\EasycreditResponseErrorTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
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
    protected const HEADER_CONTENT_TYPE = 'Content-Type';

    protected const CONTENT_TYPE_JSON = 'application/json';

    protected const URL_CREDIT_ASSESSMENTS_IDENTIFIER = 'entscheidung';
    protected const URL_ORDER_COMPLETION_IDENTIFIER = 'bestaetigen';
    protected const URL_APPROVAL_TEXT_IDENTIFIER = 'zustimmung';
    protected const URL_DISPLAY_INTEREST_IDENTIFIER = 'finanzierung';

    protected const REQUEST_TYPE_PROCESS = 'vorgang';
    protected const REQUEST_TYPE_TEXT = 'texte';

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
     * @param EasycreditRequestTransfer $requestTransfer
     *
     * @return string
     */
    abstract protected function getUrl(EasycreditRequestTransfer $requestTransfer): string;

    /**
     * @return string
     */
    abstract protected function getMethod(): string;

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
     * @return \Generated\Shared\Transfer\EasycreditResponseTransfer
     */
    public function sendRequest(EasycreditRequestTransfer $transfer): EasycreditResponseTransfer
    {
        $url = $this->getUrl($transfer);
        $method = $this->getMethod();
        $options[RequestOptions::BODY] = $this->utilEncodingService->encodeJson($transfer->getPayload());
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
            $response = $this->client->request($method, $url, $options);
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
