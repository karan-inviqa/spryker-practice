<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Communication\Form\DataProvider;

use Generated\Shared\Transfer\EmployeeTransfer;
use Orm\Zed\Employee\Persistence\Map\PyzEmployeeTableMap;
use Pyz\Zed\Employee\Communication\Form\EmployeeForm;

class EmployeeFormDataProvider
{
    /**
     * @var \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInerface
     */
    protected $customerQueryContainer;

    /**
     * @var \Pyz\Zed\Employee\Dependency\Facade\CustomerToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @param \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInerface $customerQueryContainer
     */
    public function __construct($customerQueryContainer)
    {
        $this->customerQueryContainer = $customerQueryContainer;
    }

    public function getData(): EmployeeTransfer
    {
        return new EmployeeTransfer();
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            EmployeeForm::OPTION_SALUTATION_CHOICES => $this->getSalutationChoices(),
            EmployeeForm::OPTION_GENDER_CHOICES => $this->getGenderChoices(),
        ];
    }

    protected function getSalutationChoices()
    {
        $salutationSet = PyzEmployeeTableMap::getValueSet(PyzEmployeeTableMap::COL_SALUTATION);
        return array_combine($salutationSet, $salutationSet);
    }

    /**
     * @return array
     */
    protected function getGenderChoices()
    {
        $genderSet = PyzEmployeeTableMap::getValueSet(PyzEmployeeTableMap::COL_GENDER);

        return array_combine($genderSet, $genderSet);
    }
}
