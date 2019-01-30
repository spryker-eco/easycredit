<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditPersistenceFactory getFactory()
 */
class EasycreditRepository extends AbstractRepository implements EasycreditRepositoryInterface
{
    /**
     * @param int $fkSalesOrderItem
     *
     * @return PaymentEasycreditOrderIdentifierTransfer
     */
    public function findPaymentEasycreditOrderIdentifierByFkSalesOrderItem(int $fkSalesOrderItem): PaymentEasycreditOrderIdentifierTransfer
    {
        $paymentEasycreditOrderIdentifier = $this->getFactory()->createPaymentEasycreditOrderIdentifierQuery()
            ->findOneByFkSalesOrderItem($fkSalesOrderItem);

        return $this->getFactory()
            ->createEasycreditPersistenceMapper()
            ->mapEntityToSpyPaymentEasycreditOrderIdentifierTransfer($paymentEasycreditOrderIdentifier, new PaymentEasycreditOrderIdentifierTransfer());
    }
}
