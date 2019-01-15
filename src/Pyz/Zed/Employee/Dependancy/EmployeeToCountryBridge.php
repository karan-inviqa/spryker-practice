<?php

namespace Pyz\Zed\Employee\Dependancy;


use Generated\Shared\Transfer\CountryCollectionTransfer;
use Generated\Shared\Transfer\CountryTransfer;
use Spryker\Zed\Country\Business\CountryFacadeInterface;

class EmployeeToCountryBridge implements EmployeeToCountryInterface
{
    /**
     * @var CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * EmployeeToCountryBridge constructor.
     * @param CountryFacadeInterface $countryFacade
     */
    public function __construct(CountryFacadeInterface $countryFacade)
    {
        $this->countryFacade = $countryFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\CountryCollectionTransfer
     */
    public function getAvailableCountries(): CountryCollectionTransfer
    {
        return $this->countryFacade->getAvailableCountries();
    }

    /**
     * @param string $iso2Code
     *
     * @return \Generated\Shared\Transfer\CountryTransfer
     */
    public function getCountryByIso2Code($iso2Code): CountryTransfer
    {
        return $this->countryFacade->getCountryByIso2Code($iso2Code);
    }
}