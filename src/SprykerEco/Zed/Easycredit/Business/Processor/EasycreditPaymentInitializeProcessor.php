<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class EasycreditPaymentInitializeProcessor implements EasycreditPaymentInitializeProcessorInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface
     */
    protected $mapper;

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
     * @param \SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface $mapper
     * @param \SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface $parser
     * @param \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface $easycreditLogger
     */
    public function __construct(
        MapperInterface $mapper,
        ParserInterface $parser,
        AdapterInterface $adapter,
        EasycreditLoggerInterface $easycreditLogger
    ) {
        $this->mapper = $mapper;
        $this->parser = $parser;
        $this->adapter = $adapter;
        $this->logger = $easycreditLogger;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        $requestTransfer = $this->map($quoteTransfer);
        $responseTransfer = $this->adapter->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_PAYMENT_INITIALIZE, $requestTransfer, $responseTransfer);

        return $this->parser->parse($responseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    protected function map(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setPayload($this->mapper->map($quoteTransfer));

        if ($quoteTransfer->getPayment() && $quoteTransfer->getPayment()->getEasycredit()) {
            $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        }

        return $requestTransfer;
    }
}
