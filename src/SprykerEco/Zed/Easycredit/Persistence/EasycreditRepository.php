<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @param int $fkSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function findPaymentEasycreditOrderIdentifierByFkSalesOrderItem(int $fkSalesOrder): PaymentEasycreditOrderIdentifierTransfer
    {
        $paymentEasycreditOrderIdentifier = $this->getFactory()->createPaymentEasycreditOrderIdentifierQuery()
            ->findOneByFkSalesOrder($fkSalesOrder);

        return $this->getFactory()
            ->createEasycreditPersistenceMapper()
            ->mapEntityToSpyPaymentEasycreditOrderIdentifierTransfer($paymentEasycreditOrderIdentifier, new PaymentEasycreditOrderIdentifierTransfer());
    }
}
