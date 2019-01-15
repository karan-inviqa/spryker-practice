<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Communication\Form;

use DateTime;
use Generated\Shared\Transfer\EmployeeTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInerface getQueryContainer()
 * @method \Pyz\Zed\Employee\Communication\CustomerCommunicationFactory getFactory()
 */
class EmployeeForm extends AbstractType
{
    public const OPTION_SALUTATION_CHOICES = 'salutation_choices';
    public const OPTION_GENDER_CHOICES = 'gender_choices';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(self::OPTION_SALUTATION_CHOICES);
        $resolver->setRequired(self::OPTION_GENDER_CHOICES);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addIdEmployeeField($builder)
            ->addEmailField($builder)
            ->addSalutationField($builder, $options[self::OPTION_SALUTATION_CHOICES])
            ->addFirstNameField($builder)
            ->addLastNameField($builder)
            ->addCurrentAddressField($builder)
            ->addPermanentAddressField($builder)
            ->addGenderField($builder, $options[self::OPTION_GENDER_CHOICES])
            ->addDateOfBirthField($builder)
            ->addPhoneField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPhoneField(FormBuilderInterface $builder)
    {
        $phoneConstraints = [
            new Length(['max' => 255]),
        ];

        $builder->add(EmployeeTransfer::PHONE, TextType::class, [
            'label' => 'Phone',
            'required' => false,
            'constraints' => $phoneConstraints,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDateOfBirthField(FormBuilderInterface $builder)
    {
        $builder->add(EmployeeTransfer::DATE_OF_BIRTH, DateType::class, [
            'label' => 'Date of birth',
            'widget' => 'single_text',
            'required' => false,
            'attr' => [
                'class' => 'datepicker safe-datetime',
            ],
        ]);

        $builder->get(EmployeeTransfer::DATE_OF_BIRTH)
            ->addModelTransformer($this->createDateTimeModelTransformer());

        return $this;
    }

    /**
     * @return \Symfony\Component\Form\CallbackTransformer
     */
    protected function createDateTimeModelTransformer()
    {
        return new CallbackTransformer(
            function ($dateAsString) {
                if ($dateAsString !== null) {
                    return new DateTime($dateAsString);
                }
            },
            function ($dateAsObject) {
                return $dateAsObject;
            }
        );
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addGenderField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(EmployeeTransfer::GENDER, ChoiceType::class, [
            'label' => 'Gender',
            'placeholder' => 'Select one',
            'choices' => array_flip($choices),
            'choices_as_values' => true,
            'constraints' => [
                new Required(),
            ],
            'required' => false,
        ]);

        return $this;
    }

    private function addPermanentAddressField(FormBuilderInterface $builder)
    {
        $builder->add(EmployeeTransfer::PERMANENT_ADDRESS, TextareaType::class, [
            'label' => 'Permanent Address'
        ]);
        return $this;
    }

    /**
     * @param FormBuilderInterface $builder
     */
    private function addCurrentAddressField(FormBuilderInterface $builder)
    {
        $builder->add(EmployeeTransfer::CURRENT_ADDRESS, TextareaType::class, [
            'label' => 'Current Address'
        ]);
        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addLastNameField(FormBuilderInterface $builder)
    {
        $builder->add(EmployeeTransfer::LAST_NAME, TextType::class, [
            'label' => 'Last Name',
            'constraints' => $this->getTextFieldConstraints(),
        ]);

        return $this;
    }

    /**
     * @return array
     */
    protected function getTextFieldConstraints()
    {
        return [
            new Required(),
            new NotBlank(),
            new Length(['max' => 100]),
        ];
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addFirstNameField(FormBuilderInterface $builder)
    {
        $builder->add(EmployeeTransfer::FIRST_NAME, TextType::class, [
            'label' => 'First Name',
            'constraints' => $this->getTextFieldConstraints(),
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addSalutationField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(EmployeeTransfer::SALUTATION, ChoiceType::class, [
            'label' => 'Salutation',
            'placeholder' => 'Select one',
            'choices' => array_flip($choices),
            'choices_as_values' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addEmailField(FormBuilderInterface $builder)
    {
        $builder->add(EmployeeTransfer::EMAIL, EmailType::class, [
            'label' => 'Email',
            'constraints' => $this->createEmailConstraints(),
        ]);

        return $this;
    }

    /**
     * @return array
     */
    protected function createEmailConstraints()
    {
        $emailConstraints = [
            new NotBlank(),
            new Required(),
            new Email(),
        ];

        $employeeQuery = $this->getQueryContainer()->queryEmployees();

        $emailConstraints[] = new Callback([
            'callback' => function ($email, ExecutionContextInterface $context) use ($employeeQuery) {
                if ($employeeQuery->findByEmail($email)->count() > 0) {
                    $context->addViolation('Email is already used');
                }
            },
        ]);

        return $emailConstraints;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIdEmployeeField(FormBuilderInterface $builder)
    {
        $builder->add(EmployeeTransfer::ID_EMPLOYEE, HiddenType::class);

        return $this;
    }

    /**
     * @deprecated Use `getBlockPrefix()` instead.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'employee';
    }

    private function getTextAreaConstrains()
    {
        return [
            new Length(['max' => 255]),
        ];
    }
}
