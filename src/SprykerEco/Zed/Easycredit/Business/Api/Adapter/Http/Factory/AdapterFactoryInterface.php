<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory;

use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;

interface AdapterFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createInitializePaymentAdapter(): AdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createPreContractualInformationAndRedemptionPlanAdapter(): AdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createOrderConfirmationAdapter(): AdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createInterestAndTotalSumAdapter(): AdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createQueryCreditAssessmentAdapter(): AdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createApprovalTextAdapter(): AdapterInterface;
}
