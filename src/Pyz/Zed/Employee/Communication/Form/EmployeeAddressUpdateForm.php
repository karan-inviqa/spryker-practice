<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2019-01-01
 * Time: 16:31
 */

namespace Pyz\Zed\Employee\Communication\Form;


class EmployeeAddressUpdateForm extends EmployeeAddressForm
{
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'employee_address_update';
    }
}