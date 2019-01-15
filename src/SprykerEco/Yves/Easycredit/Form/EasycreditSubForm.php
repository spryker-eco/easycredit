<?php

namespace SprykerEco\Yves\Easycredit\Form;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Shared\Easycredit\EasycreditConfig;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EasycreditSubForm extends AbstractSubFormType implements SubFormInterface
{
    /**
     * @return string
     */
    public function getPropertyPath()
    {
        return PaymentTransfer::EASYCREDIT;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return EasycreditConfig::PAYMENT_METHOD;
    }

    /**
     * @return string
     */
    protected function getTemplatePath(): string
    {
        return EasycreditConfig::PROVIDER_NAME . '/' . EasycreditConfig::PAYMENT_METHOD;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ])->setRequired(SubFormInterface::OPTIONS_FIELD_NAME);
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolver $resolver): void
    {
        $this->configureOptions($resolver);
    }
}
