<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor;

use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface;

class OrderConfirmationProcessor implements OrderConfirmationProcessorInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface
     */
    protected $parser;

    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface
     */
    protected $logger;

    /**
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface
     */
    protected $easycreditRepository;

    /**
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface
     */
    protected $easycreditEntityManager;

    /**
     * @param \SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface $parser
     * @param \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface $logger
     * @param \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface $easycreditRepository
     * @param \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface $easycreditEntityManager
     */
    public function __construct(
        ParserInterface $parser,
        AdapterInterface $adapter,
        EasycreditLoggerInterface $logger,
        EasycreditRepositoryInterface $easycreditRepository,
        EasycreditEntityManagerInterface $easycreditEntityManager
    ) {
        $this->parser = $parser;
        $this->adapter = $adapter;
        $this->logger = $logger;
        $this->easycreditRepository = $easycreditRepository;
        $this->easycreditEntityManager = $easycreditEntityManager;
    }

    /**
     * @param int $fkSalesOrder
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function process(int $fkSalesOrder): EasycreditOrderConfirmationResponseTransfer
    {
        $paymentEasycreditOrderIdentifierTransfer = $this->getEasycreditOrderIdentifierTransfer($fkSalesOrder);

        if ($paymentEasycreditOrderIdentifierTransfer->getConfirmed()) {
            $responseTransfer = new EasycreditOrderConfirmationResponseTransfer();
            $responseTransfer->setConfirmed(true);

            return $responseTransfer;
        }

        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($paymentEasycreditOrderIdentifierTransfer->getIdentifier());

        $easycreditResponseTransfer = $this->adapter->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_ORDER_CONFIRMATION, $requestTransfer, $easycreditResponseTransfer);

        $responseTransfer = $this->parser->parse($easycreditResponseTransfer);

        /** @var \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer $responseTransfer */
        if ($responseTransfer->getConfirmed()) {
            $paymentEasycreditOrderIdentifierTransfer->setConfirmed(true);
            $this->easycreditEntityManager->saveEasycreditOrderIdentifier($paymentEasycreditOrderIdentifierTransfer);
        }

        return $responseTransfer;
    }

    /**
     * @param int $fkSalesOrder
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    protected function getEasycreditOrderIdentifierTransfer(int $fkSalesOrder): PaymentEasycreditOrderIdentifierTransfer
    {
        return $this->easycreditRepository->findPaymentEasycreditOrderIdentifierByFkSalesOrderItem($fkSalesOrder);
    }
}
