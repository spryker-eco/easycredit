<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory;

use GuzzleHttp\ClientInterface;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\ApprovalTextAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InitializePaymentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InterestAndTotalSumAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\OrderConfirmationAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\PreContractualInformationAndRedemptionPlanAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\QueryCreditAssessmentAdapter;
use SprykerEco\Zed\Easycredit\EasycreditConfig;

class AdapterFactory implements AdapterFactoryInterface
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var \SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @var \SprykerEco\Zed\Easycredit\EasycreditConfig
     */
    protected $config;

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
        $this->client = $client;
        $this->utilEncodingService = $utilEncodingService;
        $this->config = $config;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createInitializePaymentAdapter(): AdapterInterface
    {
        return new InitializePaymentAdapter($this->client, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createPreContractualInformationAndRedemptionPlanAdapter(): AdapterInterface
    {
        return new PreContractualInformationAndRedemptionPlanAdapter($this->client, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createOrderConfirmationAdapter(): AdapterInterface
    {
        return new OrderConfirmationAdapter($this->client, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createInterestAndTotalSumAdapter(): AdapterInterface
    {
        return new InterestAndTotalSumAdapter($this->client, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createQueryCreditAssessmentAdapter(): AdapterInterface
    {
        return new QueryCreditAssessmentAdapter($this->client, $this->utilEncodingService, $this->config);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createApprovalTextAdapter(): AdapterInterface
    {
        return new ApprovalTextAdapter($this->client, $this->utilEncodingService, $this->config);
    }
}
