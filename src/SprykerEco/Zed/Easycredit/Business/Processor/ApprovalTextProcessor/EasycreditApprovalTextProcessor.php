<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
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
     * @var EasycreditLoggerInterface
     */
    protected $logger;

    /**
     * @param ParserInterface $parser
     * @param AdapterInterface $adapter
     * @param EasycreditLoggerInterface $easycreditLogger
     */
    public function __construct(
        ParserInterface $parser,
        AdapterInterface $adapter,
        EasycreditLoggerInterface $easycreditLogger
    ) {
        $this->parser = $parser;
        $this->adapter = $adapter;
        $this->logger = $easycreditLogger;
    }

    /**
     * @return EasycreditApprovalTextResponseTransfer
     */
    public function process(): EasycreditApprovalTextResponseTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $response = $this->adapter->sendRequest($requestTransfer);
        $responseTransfer = $this->parser->parse($response);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_APPROVAL_TEXT, $requestTransfer, $responseTransfer);

        return $responseTransfer;
    }
}
