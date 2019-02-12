<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;

interface EasycreditRepositoryInterface
{
    /**
     * @param int $fkSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function findPaymentEasycreditOrderIdentifierByFkSalesOrderItem(int $fkSalesOrder): PaymentEasycreditOrderIdentifierTransfer;
}
