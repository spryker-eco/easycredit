<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
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
     * @param ParserInterface $parser
     * @param AdapterInterface $adapter
     */
    public function __construct(
        ParserInterface $parser,
        AdapterInterface $adapter
    ) {
        $this->parser = $parser;
        $this->adapter = $adapter;
    }

    /**
     * @param int $idOrder
     *
     * @return void
     */
    public function process(int $idOrder): void
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($this->getOrderIdentifier($idOrder));
        $response = $this->adapter->sendRequest($requestTransfer);
        $success = $this->parser->parse($response)->getConfirmed();
        //TODO: Store the confirmed value to db
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
