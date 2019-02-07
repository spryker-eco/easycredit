<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Logger;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface;

class EasycreditLogger implements EasycreditLoggerInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface $entityManager
     */
    public function __construct(
        EasycreditEntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $type
     * @param \Generated\Shared\Transfer\EasycreditRequestTransfer $request
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $response
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer
     */
    public function saveApiLog(string $type, EasycreditRequestTransfer $request, EasycreditResponseTransfer $response): PaymentEasycreditApiLogTransfer
    {
        $paymentEasycreditApiLog = (new PaymentEasycreditApiLogTransfer())
            ->setType($type)
            ->setRequest($request->serialize())
            ->setResponse($response->serialize());

        if ($response->getError()) {
            $paymentEasycreditApiLog
                ->setStatusCode($response->getError()->getStatusCode())
                ->setErrorCode($response->getError()->getErrorCode())
                ->setErrorMessage($response->getError()->getErrorMessage());
        }

        return $this->entityManager->saveEasycreditApiLog($paymentEasycreditApiLog);
    }
}
