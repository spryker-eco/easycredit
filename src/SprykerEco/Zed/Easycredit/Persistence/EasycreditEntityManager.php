<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditPersistenceFactory getFactory()
 */
class EasycreditEntityManager extends AbstractEntityManager implements EasycreditEntityManagerInterface
{
    /**
     * @param PaymentEasycreditApiLogTransfer $apiLogTransfer
     *
     * @return PaymentEasycreditApiLogTransfer
     */
    public function saveEasycreditApiLog(PaymentEasycreditApiLogTransfer $apiLogTransfer): PaymentEasycreditApiLogTransfer
    {
        $easycreditApiLog = $this->getFactory()
            ->createEasycreditPersistenceMapper()
            ->mapPaymentEasycreditApiLogTransferToEntity($apiLogTransfer, new SpyPaymentEasycreditApiLog());

        $easycreditApiLog->save();

        return $this->getFactory()
            ->createEasycreditPersistenceMapper()
            ->mapEntityToPaymentEasycreditApiLogTransfer($easycreditApiLog, $apiLogTransfer);
    }

    /**
     * @param PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     * @return PaymentEasycreditOrderIdentifierTransfer
     *
     */
    public function saveEasycreditOrderIdentifier(PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer): PaymentEasycreditOrderIdentifierTransfer
    {
        $easycreditOrderIdentifier = $this->getFactory()
            ->createEasycreditPersistenceMapper()
            ->mapEasycreditOrderIdentifierTransferToEntity($paymentEasycreditOrderIdentifierTransfer, new SpyPaymentEasycreditOrderIdentifier());

        $easycreditOrderIdentifier->save();

        return $this->getFactory()
            ->createEasycreditPersistenceMapper()
            ->mapEntityToSpyPaymentEasycreditOrderIdentifierTransfer($easycreditOrderIdentifier, $paymentEasycreditOrderIdentifierTransfer);
    }
}
