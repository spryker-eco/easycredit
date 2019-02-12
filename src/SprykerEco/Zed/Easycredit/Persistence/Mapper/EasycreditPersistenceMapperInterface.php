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

interface EasycreditPersistenceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
     *
     * @return \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog
     */
    public function mapPaymentEasycreditApiLogTransferToEntity(
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer,
        SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
    ): SpyPaymentEasycreditApiLog;

    /**
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
     * @param \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer
     */
    public function mapEntityToPaymentEasycreditApiLogTransfer(
        SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog,
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
    ): PaymentEasycreditApiLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier
     *
     * @return \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier
     */
    public function mapEasycreditOrderIdentifierTransferToEntity(
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer,
        SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier
    ): SpyPaymentEasycreditOrderIdentifier;

    /**
     * @param \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function mapEntityToSpyPaymentEasycreditOrderIdentifierTransfer(
        SpyPaymentEasycreditOrderIdentifier $spyPaymentEasycreditOrderIdentifier,
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
    ): PaymentEasycreditOrderIdentifierTransfer;
}
