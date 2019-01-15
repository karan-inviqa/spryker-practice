<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2019-01-04
 * Time: 12:58
 */

namespace Pyz\Zed\Employee\Communication\Form\DataProvider;


use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Generated\Shared\Transfer\EmployeeCreationFormTransfer;
use Orm\Zed\Employee\Persistence\Map\PyzEmployeeTableMap;
use Pyz\Zed\Employee\Communication\Form\EmployeeAddressForm;
use Pyz\Zed\Employee\Dependancy\EmployeeToCountryInterface;
use Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface;
use Spryker\Shared\Kernel\Store;

class EmployeeAddressesDataProvider
{
    /**
     * @var EmployeeQueryContainerInerface
     */
    protected $employeeQueryContainer;

    /**
     * @var \Pyz\Zed\Employee\Dependency\Facade\CustomerToLocaleInterface
     */
    protected $localeFacade;

    /**
     * @var CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @var Store
     */
    protected $store;

    public function __construct(
        EmployeeQueryContainerInterface $employeeQueryContainer,
        EmployeeToCountryInterface $countryFacade,
        Store $store
    )
    {
        $this->employeeQueryContainer = $employeeQueryContainer;
        $this->countryFacade = $countryFacade;
        $this->store = $store;
    }

    public function getData(EmployeeCreationFormTransfer $employeeCreationFormTransfer): EmployeeCreationFormTransfer
    {
        $address = new EmployeeAddressTransfer();
        $employeeCreationFormTransfer->addAddress($address);

        return $employeeCreationFormTransfer;
    }

    /**
     * @return array
     */
    /*public function getOptions()
    {
        $options = [
            'data_class' => EmployeeCreationFormTransfer::class,
            EmployeeAddressForm::OPTION_SALUTATION_CHOICES => $this->getSalutationChoices(),
            EmployeeAddressForm::OPTION_COUNTRY_CHOICES => $this->getCountryChoices(),
            EmployeeAddressForm::OPTION_REGION_CHOICES => $this->getRegionChoices(),
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ];

        return $options;
    }*/

    public function getOptions()
    {
        $options = [
            EmployeeAddressForm::OPTION_SALUTATION_CHOICES => [
                EmployeeAddressForm::OPTION_SALUTATION_CHOICES => array_flip($this->getSalutationChoices())
            ],
            EmployeeAddressForm::OPTION_COUNTRY_CHOICES => [
                EmployeeAddressForm::OPTION_COUNTRY_CHOICES => array_flip($this->getCountryChoices())
            ],
            EmployeeAddressForm::OPTION_REGION_CHOICES => [
                EmployeeAddressForm::OPTION_REGION_CHOICES => array_flip($this->getRegionChoices())
            ]
        ];


        return $options;
    }


    protected function getSalutationChoices()
    {
        $salutationSet = PyzEmployeeTableMap::getValueSet(PyzEmployeeTableMap::COL_SALUTATION);
        return array_combine($salutationSet, $salutationSet);
    }

    private function getCountryChoices(): array
    {
        $result = [];
        foreach ($this->store->getCountries() as $country) {
            $countryTransfer = $this->countryFacade->getCountryByIso2Code($country);
            $result[$countryTransfer->getIdCountry()] = $countryTransfer->getName();
        }

        return $result;
    }

    private function getRegionChoices()
    {
        $result = [];

        return $result;
    }
}