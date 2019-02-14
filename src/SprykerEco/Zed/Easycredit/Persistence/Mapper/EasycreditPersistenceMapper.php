<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Persistence\Mapper;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier;

class EasycreditPersistenceMapper implements EasycreditPersistenceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog $paymentEasycreditApiLogEntity
     *
     * @return \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog
     */
    public function mapPaymentEasycreditApiLogTransferToEntity(
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer,
        SpyPaymentEasycreditApiLog $paymentEasycreditApiLogEntity
    ): SpyPaymentEasycreditApiLog {
        $paymentEasycreditApiLogEntity->fromArray($easycreditApiLogTransfer->modifiedToArray());
        $paymentEasycreditApiLogEntity->setNew($easycreditApiLogTransfer->getIdPaymentEasycreditApiLog() === null);

        return $paymentEasycreditApiLogEntity;
    }

    /**
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog $paymentEasycreditApiLogEntity
     * @param \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer
     */
    public function mapEntityToPaymentEasycreditApiLogTransfer(
        SpyPaymentEasycreditApiLog $paymentEasycreditApiLogEntity,
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
    ): PaymentEasycreditApiLogTransfer {
        return $easycreditApiLogTransfer->fromArray($paymentEasycreditApiLogEntity->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier $paymentEasycreditOrderIdentifierEntity
     *
     * @return \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier
     */
    public function mapEasycreditOrderIdentifierTransferToEntity(
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer,
        SpyPaymentEasycreditOrderIdentifier $paymentEasycreditOrderIdentifierEntity
    ): SpyPaymentEasycreditOrderIdentifier {
        $paymentEasycreditOrderIdentifierEntity->fromArray($paymentEasycreditOrderIdentifierTransfer->modifiedToArray());
        $paymentEasycreditOrderIdentifierEntity->setNew($paymentEasycreditOrderIdentifierTransfer->getIdPaymentEasycreditOrderIdentifier() === null);

        return $paymentEasycreditOrderIdentifierEntity;
    }

    /**
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier $paymentEasycreditOrderIdentifierEntity
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function mapEntityToSpyPaymentEasycreditOrderIdentifierTransfer(
        SpyPaymentEasycreditOrderIdentifier $paymentEasycreditOrderIdentifierEntity,
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
    ): PaymentEasycreditOrderIdentifierTransfer {
        return $paymentEasycreditOrderIdentifierTransfer->fromArray($paymentEasycreditOrderIdentifierEntity->toArray(), true);
    }
}
