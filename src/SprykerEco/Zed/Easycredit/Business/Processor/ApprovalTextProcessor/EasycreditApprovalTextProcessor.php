<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @param \SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface $parser
     * @param \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface $adapter
     * @param \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface $easycreditLogger
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
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function process(): EasycreditApprovalTextResponseTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $responseTransfer = $this->adapter->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_APPROVAL_TEXT, $requestTransfer, $responseTransfer);

        return $this->parser->parse($responseTransfer);
    }
}
