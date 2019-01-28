<?php

namespace SprykerEco\Yves\Easycredit\Form;

use Generated\Shared\Transfer\EasycreditTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormProviderNameInterface;
use SprykerEco\Shared\Easycredit\EasycreditConfig;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;

class EasycreditSubForm extends AbstractSubFormType implements SubFormInterface, SubFormProviderNameInterface
{
    public const VARS_KEY_LEGAL_TEXT = 'legalText';
    protected const FIELD_OPT_IN_CHECKBOX = 'optInCheckbox';

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
        return PaymentTransfer::EASYCREDIT;
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $selectedOptions = $options[static::OPTIONS_FIELD_NAME];
        $view->vars[static::VARS_KEY_LEGAL_TEXT] = $selectedOptions[static::VARS_KEY_LEGAL_TEXT];
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
            'data_class' => EasycreditTransfer::class,
            SubFormInterface::OPTIONS_FIELD_NAME => [],
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addCreditCardPaymentOptions($builder, $options);
    }
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    public function addCreditCardPaymentOptions(FormBuilderInterface $builder, array $options): self
    {
        $builder->add(
            static::FIELD_OPT_IN_CHECKBOX,
            CheckboxType::class,
            [
                'label' => '',
                'required' => true,
                'constraints' => [
                    $this->createNotBlankConstraint(),
                ],
            ]
        );

        return $this;
    }

    /**
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function createNotBlankConstraint(): Constraint
    {
        return new NotBlank(['groups' => $this->getPropertyPath()]);
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return PaymentTransfer::EASYCREDIT;
    }
}
