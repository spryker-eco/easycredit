<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;

interface EasycreditRepositoryInterface
{
    /**
     * @param int $fkSalesOrder
     *
     * @return PaymentEasycreditOrderIdentifierTransfer
     */
    public function findPaymentEasycreditOrderIdentifierByFkSalesOrderItem(int $fkSalesOrder): PaymentEasycreditOrderIdentifierTransfer;
}
