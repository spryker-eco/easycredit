<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class EasycreditApprovalTextProcessor implements EasycreditApprovalTextProcessorInterface
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
     * @return EasycreditApprovalTextResponseTransfer
     */
    public function process(): EasycreditApprovalTextResponseTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();

        $response = $this->adapter->sendRequest($requestTransfer);

        return $this->parser->parse($response);
    }
}