<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\PreContractualInformationAndRedemptionPlanProcessor;

use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class PreContractualInformationAndRedemptionPlanProcessor implements PreContractualInformationAndRedemptionPlanProcessorInterface
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
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());

        $responseTransfer = $this->adapter->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_PRE_CONTRACTUAL_INFORMATION_AMD_REDEMPTION_PLAN, $requestTransfer, $responseTransfer);

        return $this->parser->parse($responseTransfer);
    }
}
