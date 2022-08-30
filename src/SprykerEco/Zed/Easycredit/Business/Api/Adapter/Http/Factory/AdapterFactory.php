<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory;

use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\ApprovalTextAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InitializePaymentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InterestAndTotalSumAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\OrderConfirmationAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\PreContractualInformationAndRedemptionPlanAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\QueryCreditAssessmentAdapter;
use SprykerEco\Zed\Easycredit\Dependency\External\EasycreditToHttpClientInterface;
use SprykerEco\Zed\Easycredit\EasycreditConfig;

class AdapterFactory implements AdapterFactoryInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\Dependency\External\EasycreditToHttpClientInterface
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
     * @param \SprykerEco\Zed\Easycredit\Dependency\External\EasycreditToHttpClientInterface $httpClient
     * @param \SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface $utilEncodingService
     * @param \SprykerEco\Zed\Easycredit\EasycreditConfig $config
     */
    public function __construct(
        EasycreditToHttpClientInterface $httpClient,
        EasycreditToUtilEncodingServiceInterface $utilEncodingService,
        EasycreditConfig $config
    ) {
        $this->httpClient = $httpClient;
        $this->utilEncodingService = $utilEncodingService;
        $this->config = $config;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createInitializePaymentAdapter(): EasycreditAdapterInterface
    {
        return new InitializePaymentAdapter($this->httpClient, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createPreContractualInformationAndRedemptionPlanAdapter(): EasycreditAdapterInterface
    {
        return new PreContractualInformationAndRedemptionPlanAdapter($this->httpClient, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createOrderConfirmationAdapter(): EasycreditAdapterInterface
    {
        return new OrderConfirmationAdapter($this->httpClient, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createInterestAndTotalSumAdapter(): EasycreditAdapterInterface
    {
        return new InterestAndTotalSumAdapter($this->httpClient, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createQueryCreditAssessmentAdapter(): EasycreditAdapterInterface
    {
        return new QueryCreditAssessmentAdapter($this->httpClient, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createApprovalTextAdapter(): EasycreditAdapterInterface
    {
        return new ApprovalTextAdapter($this->httpClient, $this->utilEncodingService, $this->config);
    }
}
