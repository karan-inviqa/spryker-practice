<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2019-01-01
 * Time: 15:26
 */

namespace Pyz\Zed\Employee\Communication\Form\DataProvider;


use Generated\Shared\Transfer\EmployeeAddressTransfer;

class EmployeeAddressUpdateFormProvider extends EmployeeAddressFormDataProvider
{
    /**
     * @param EmployeeAddressTransfer|null $employeeAddressTransfer
     * @return array
     */
    public function getData(EmployeeAddressTransfer $employeeAddressTransfer = null)
    {
        if ($employeeAddressTransfer === null) {
            return parent::getData();
        }

        $addressData = $this->employeeQueryContainer->queryAddressByIdEmploye($employeeAddressTransfer)->findOne();
        $data = $addressData->toArray();

        return $data;
    }
}