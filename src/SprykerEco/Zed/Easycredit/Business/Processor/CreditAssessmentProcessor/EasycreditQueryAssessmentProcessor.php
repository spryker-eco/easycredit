<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor;

use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;

class EasycreditQueryAssessmentProcessor implements EasycreditQueryAssessmentProcessorInterface
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
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditQueryAssessmentResponseTransfer
     */
    public function process(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer
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

        if ($quoteTransfer->getPayment() && $quoteTransfer->getPayment()->getEasycredit()) {
            $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        }

        return $requestTransfer;
    }
}
