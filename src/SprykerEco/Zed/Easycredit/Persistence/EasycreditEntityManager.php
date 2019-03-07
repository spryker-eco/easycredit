<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifier;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditPersistenceFactory getFactory()
 *
 * @SuppressWarnings(PHPMD)
 */
class EasycreditEntityManager extends AbstractEntityManager implements EasycreditEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer $apiLogTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer
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
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
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
