<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Communication\Form;

use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInerface getQueryContainer()
 * @method \Pyz\Zed\Employee\Communication\CustomerCommunicationFactory getFactory()
 */
class Addresses extends AbstractType
{
    public const FIELD_TYPE_ADDRESSES = 'addresses';


    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(EmployeeAddressForm::OPTION_SALUTATION_CHOICES);
        $resolver->setRequired(EmployeeAddressForm::OPTION_COUNTRY_CHOICES);
        $resolver->setRequired(EmployeeAddressForm::OPTION_REGION_CHOICES);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(self::FIELD_TYPE_ADDRESSES, CollectionType::class, [
            'entry_type' => EmployeeAddressForm::class,
            'allow_add' => true,
            'allow_delete' => true,
            'delete_empty' => true,
            'entry_options' => [
                'data_class' => EmployeeAddressTransfer::class,
                EmployeeAddressForm::OPTION_COUNTRY_CHOICES => $options[EmployeeAddressForm::OPTION_COUNTRY_CHOICES],
                EmployeeAddressForm::OPTION_REGION_CHOICES => $options[EmployeeAddressForm::OPTION_REGION_CHOICES],
                EmployeeAddressForm::OPTION_SALUTATION_CHOICES => $options[EmployeeAddressForm::OPTION_SALUTATION_CHOICES],
            ]
        ]);
    }

}
