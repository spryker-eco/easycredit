<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\InterestAndAdjustTotalSumProcessor;

use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class InterestAndAdjustTotalSumProcessor implements InterestAndAdjustTotalSumProcessorInterface
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
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $responseTransfer = $this->adapter->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_INTEREST_AND_ADJUST_TOTAL_SUM, $requestTransfer, $responseTransfer);

        return $this->parser->parse($responseTransfer);
    }
}
