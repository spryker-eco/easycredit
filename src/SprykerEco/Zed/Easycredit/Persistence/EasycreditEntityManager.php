<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditApiLog;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditPersistenceFactory getFactory()
 */
class EasycreditEntityManager extends AbstractEntityManager implements EasycreditEntityManagerInterface
{
    /**
     * @param PaymentEasycreditApiLogTransfer $apiLogTransfer
     *
     * @return mixed
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
}
