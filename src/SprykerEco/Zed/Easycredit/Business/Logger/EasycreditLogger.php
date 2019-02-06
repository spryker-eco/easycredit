<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Logger;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;

class EasycreditLogger implements EasycreditLoggerInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param string $type
     * @param EasycreditRequestTransfer $request
     * @param EasycreditResponseTransfer $response
     *
     * @return PaymentEasycreditApiLogTransfer
     */
    public function saveApiLog(string $type, EasycreditRequestTransfer $request, EasycreditResponseTransfer $response): PaymentEasycreditApiLogTransfer
    {
        $paymentEasycreditApiLog = (new PaymentEasycreditApiLogTransfer())
            ->setType($type)
            ->setRequest($request->serialize())
            ->setIsSuccess($response->getSuccess())
            ->setResponse($response->serialize());

        if (!$response->getSuccess()) {
            $paymentEasycreditApiLog
                ->setStatusCode($response->getError()->getStatusCode())
                ->setErrorCode($response->getError()->getErrorCode())
                ->setErrorMessage($response->getError()->getErrorMessage());
        }

        return $this->entityManager->saveEasycreditApiLog($paymentEasycreditApiLog);
    }
}
