<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\PaymentProcessor;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class EasycreditPaymentProcessor implements EasycreditPaymentProcessorInterface
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
     * @param QuoteTransfer $transfer
     *
     * @return AbstractTransfer
     */
    public function process(QuoteTransfer $transfer): AbstractTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setPayload($this->mapper->map($transfer));

        $response = $this->adapter->sendRequest($requestTransfer);

        return $this->parser->parse($response);
    }
}
