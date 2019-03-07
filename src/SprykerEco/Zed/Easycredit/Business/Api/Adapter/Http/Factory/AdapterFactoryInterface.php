<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory;

use SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface;

interface AdapterFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createInitializePaymentAdapter(): EasycreditAdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createPreContractualInformationAndRedemptionPlanAdapter(): EasycreditAdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createOrderConfirmationAdapter(): EasycreditAdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createInterestAndTotalSumAdapter(): EasycreditAdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createQueryCreditAssessmentAdapter(): EasycreditAdapterInterface;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface
     */
    public function createApprovalTextAdapter(): EasycreditAdapterInterface;
}
