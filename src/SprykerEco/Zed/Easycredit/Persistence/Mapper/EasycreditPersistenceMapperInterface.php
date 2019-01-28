<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence\Mapper;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog;

interface EasycreditPersistenceMapperInterface
{
    /**
     * @param PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     *
     * @param SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
     * @return SpyPaymentEasycreditApiLog
     */
    public function mapPaymentEasycreditApiLogTransferToEntity(
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer,
        SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
    ): SpyPaymentEasycreditApiLog;

    /**
     * @param SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog
     * @param PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
     *
     * @return PaymentEasycreditApiLogTransfer
     */
    public function mapEntityToPaymentEasycreditApiLogTransfer(
        SpyPaymentEasycreditApiLog $spyPaymentEasycreditApiLog,
        PaymentEasycreditApiLogTransfer $easycreditApiLogTransfer
    ): PaymentEasycreditApiLogTransfer;
}
