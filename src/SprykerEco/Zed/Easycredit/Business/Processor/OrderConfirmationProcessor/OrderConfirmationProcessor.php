<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var EasycreditLoggerInterface
     */
    protected $logger;

    /**
     * @var EasycreditRepositoryInterface
     */
    protected $easycreditRepository;

    /**
     * @var EasycreditEntityManagerInterface
     */
    protected $easycreditEntityManager;

    /**
     * @param ParserInterface $parser
     * @param AdapterInterface $adapter
     * @param EasycreditLoggerInterface $logger
     * @param EasycreditRepositoryInterface $easycreditRepository
     * @param EasycreditEntityManagerInterface $easycreditEntityManager
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
     * @return EasycreditOrderConfirmationResponseTransfer
     */
    public function process(int $fkSalesOrder): EasycreditOrderConfirmationResponseTransfer
    {
        $responseTransfer = new EasycreditOrderConfirmationResponseTransfer();

        $paymentEasycreditOrderIdentifierTransfer = $this->getEasycreditOrderIdentifierTransfer($fkSalesOrder);
        if ($paymentEasycreditOrderIdentifierTransfer->getConfirmed()) {
            $responseTransfer->setConfirmed(true);

            return $responseTransfer;
        }

        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($paymentEasycreditOrderIdentifierTransfer->getIdentifier());

        $responseTransfer = $this->parser->parse($this->adapter->sendRequest($requestTransfer));
        if ($responseTransfer->getConfirmed()) {
            $paymentEasycreditOrderIdentifierTransfer->setConfirmed(true);
            $this->easycreditEntityManager->saveEasycreditOrderIdentifier($paymentEasycreditOrderIdentifierTransfer);
        }

        return $responseTransfer;
    }


    /**
     * @param int $fkSalesOrder
     *
     * @return string
     */
    protected function getEasycreditOrderIdentifierTransfer(int $fkSalesOrder): PaymentEasycreditOrderIdentifierTransfer
    {
        return $this->easycreditRepository->findPaymentEasycreditOrderIdentifierByFkSalesOrderItem($fkSalesOrder);
    }
}
