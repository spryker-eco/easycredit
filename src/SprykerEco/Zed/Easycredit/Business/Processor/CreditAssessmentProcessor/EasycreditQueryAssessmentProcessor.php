<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor;

use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class EasycreditQueryAssessmentProcessor implements EasycreditQueryAssessmentProcessorInterface
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
     * @param \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface $logger
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
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer
    {
        $requestTransfer = $this->map($quoteTransfer);
        $responseTransfer = $this->adapter->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_CREDIT_ASSESSMENT, $requestTransfer, $responseTransfer);

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

        if ($quoteTransfer->getPayment() && $quoteTransfer->getPayment()->getEasycredit()) {
            $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        }

        return $requestTransfer;
    }
}
