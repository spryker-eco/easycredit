<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor;

use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

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
     * @param ParserInterface $parser
     * @param AdapterInterface $adapter
     * @param EasycreditLoggerInterface $logger
     */
    public function __construct(
        ParserInterface $parser,
        AdapterInterface $adapter,
        EasycreditLoggerInterface $logger
    ) {
        $this->parser = $parser;
        $this->adapter = $adapter;
        $this->logger = $logger;
    }

    /**
     * @param int $idOrder
     *
     * @return EasycreditOrderConfirmationResponseTransfer
     */
    public function process(int $idOrder): EasycreditOrderConfirmationResponseTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($this->getOrderIdentifier($idOrder));
        $response = $this->adapter->sendRequest($requestTransfer);
        $responseTransfer = $this->parser->parse($response);

//        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_ORDER_CONFIRMATION, $requestTransfer, $responseTransfer);

        return $responseTransfer;
    }


    /**
     * @param int $idOrder
     *
     * @return string
     */
    protected function getOrderIdentifier(int $idOrder): string
    {
        return uniqid(); //TODO: Change it when persistance layer is implemented
    }
}
