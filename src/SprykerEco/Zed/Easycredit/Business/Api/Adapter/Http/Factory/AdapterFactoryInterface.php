<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory;

use GuzzleHttp\ClientInterface;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\EasycreditConfig;

interface AdapterFactoryInterface
{
    /**
     * @return AdapterInterface
     */
    public function createInitializePaymentAdapter(): AdapterInterface;

    /**
     * @return AdapterInterface
     */
    public function createPreContractualInformationAndRedemptionPlanAdapter(): AdapterInterface;

    /**
     * @return AdapterInterface
     */
    public function createOrderConfirmationAdapter(): AdapterInterface;

    /**
     * @return AdapterInterface
     */
    public function createInterestAndTotalSumAdapter(): AdapterInterface;

    /**
     * @return AdapterInterface
     */
    public function createQueryCreditAssessmentAdapter(): AdapterInterface;

    /**
     * @return AdapterInterface
     */
    public function createApprovalTextAdapter(): AdapterInterface;
}
