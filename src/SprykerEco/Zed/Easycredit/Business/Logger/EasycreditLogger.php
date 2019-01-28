<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Logger;

use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class EasycreditLogger implements EasycreditLoggerInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param string $type
     * @param AbstractTransfer $request
     * @param AbstractTransfer $response
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer
     */
    public function saveApiLog(string $type, AbstractTransfer $request, AbstractTransfer $response): PaymentEasycreditApiLogTransfer
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
                ->setErrorMessage($response->getError()->getErrorMessage())
                ->setErrorType($response->getError()->getErrorType());
        }

        return $this->entityManager->saveEasycreditApiLog($paymentEasycreditApiLog);
    }
}
