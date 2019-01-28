<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class EasycreditPaymentInitializeProcessor implements EasycreditPaymentInitializeProcessorInterface
{
    /**
     * @var MapperInterface
     */
    protected $mapper;

    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param MapperInterface $mapper
     * @param ParserInterface $parser
     * @param AdapterInterface $adapter
     */
    public function __construct(
        MapperInterface $mapper,
        ParserInterface $parser,
        AdapterInterface $adapter
    ) {
        $this->mapper = $mapper;
        $this->parser = $parser;
        $this->adapter = $adapter;
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        $requestTransfer = $this->map($quoteTransfer);
        $response = $this->adapter->sendRequest($requestTransfer);

        return $this->parser->parse($response);
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditRequestTransfer
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