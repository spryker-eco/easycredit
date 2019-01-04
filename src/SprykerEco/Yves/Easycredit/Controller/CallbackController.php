<?php

namespace SprykerEco\Yves\Easycredit\Controller;

class CallbackController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function successEasyCreditAction()
    {
        return $this->processEasyCreditSuccessResponse($this->getFactory()->createEasyCreditPaymentHandler());
    }

    /**
     * @param \SprykerEco\Yves\Easycredit\Handler\ComputopPrePostPaymentHandlerInterface $handler
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function processEasyCreditSuccessResponse(ComputopPrePostPaymentHandlerInterface $handler)
    {
        $quoteTransfer = $this->getFactory()->getQuoteClient()->getQuote();
        $quoteTransfer = $handler->handle($quoteTransfer, $this->responseArray);
        $this->getFactory()->getQuoteClient()->setQuote($quoteTransfer);
        $statusResponse = $quoteTransfer->getPayment()->getComputopEasyCredit()->getEasyCreditStatusResponse();
        if (!$statusResponse->getHeader()->getIsSuccess()) {
            $this->addErrorMessage($statusResponse->getErrorText());
            return $this->redirectResponseInternal($this->getFactory()->getComputopConfig()->getCallbackFailureRedirectPath());
        }
        return $this->redirectResponseInternal($this->getFactory()->getComputopConfig()->getEasyCreditSuccessAction());
    }

}
