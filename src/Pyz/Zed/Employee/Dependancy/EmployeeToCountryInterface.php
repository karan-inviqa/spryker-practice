<?php

namespace Pyz\Zed\Employee\Dependancy;

interface EmployeeToCountryInterface
{
    /**
     * @return \Generated\Shared\Transfer\CountryCollectionTransfer
     */
    public function getAvailableCountries();

    /**
     * @param string $iso2Code
     *
     * @return \Generated\Shared\Transfer\CountryTransfer
     */
    public function getCountryByIso2Code($iso2Code);
}