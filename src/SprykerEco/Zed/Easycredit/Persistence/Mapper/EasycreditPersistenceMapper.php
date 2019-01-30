<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence\Mapper;

use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier;

class EasycreditPersistenceMapper implements EasycreditPersistenceMapperInterface
{
    /**
     * @param PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     *
     * @param SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
     * @return SpyPaymentEasycreditApiLog
     */
    public function mapPaymentEasycreditApiLogTransferToEntity(
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer,
        SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog): SpyPaymentEasycreditApiLog
    {
        $spyPaymentEasycreditApiLog->fromArray($easycreditApiLogTransfer->modifiedToArray());
        $spyPaymentEasycreditApiLog->setNew($easycreditApiLogTransfer->getIdPaymentEasycreditApiLog() === null);

        return $spyPaymentEasycreditApiLog;
    }

    /**
     * @param SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
     * @param PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     *
     * @return PaymentEasycreditApiLogTransfer
     */
    public function mapEntityToPaymentEasycreditApiLogTransfer(
        SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog,
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer): PaymentEasycreditApiLogTransfer
    {
        return $easycreditApiLogTransfer->fromArray($spyPaymentEasycreditApiLog->toArray(), true);
    }

    /**
     * @param PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     * @param SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier
     *
     * @return SpyPaymentEasycreditOrderIdentifier
     */
    public function mapEasycreditOrderIdentifierTransferToEntity(
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer,
        SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier): SpyPaymentEasycreditOrderIdentifier
    {
        $spyPaymentEasycreditOrderIdentifier->fromArray($paymentEasycreditOrderIdentifierTransfer->modifiedToArray());
        $spyPaymentEasycreditOrderIdentifier->setNew($paymentEasycreditOrderIdentifierTransfer->getIdPaymentEasycreditOrderIdentifier() === null);

        return $spyPaymentEasycreditOrderIdentifier;
    }

    /**
     * @param SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier
     * @param PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return PaymentEasycreditOrderIdentifierTransfer
     */
    public function mapEntityToSpyPaymentEasycreditOrderIdentifierTransfer(
        SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier,
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer): PaymentEasycreditOrderIdentifierTransfer
    {
        return $paymentEasycreditOrderIdentifierTransfer->fromArray($spyPaymentEasycreditOrderIdentifier->toArray(), true);
    }
}
