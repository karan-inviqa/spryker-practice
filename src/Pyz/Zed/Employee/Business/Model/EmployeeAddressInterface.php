<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2018-12-28
 * Time: 18:25
 */

namespace Pyz\Zed\Employee\Business\Model;


use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Generated\Shared\Transfer\EmployeeResponseTransfer;

interface EmployeeAddressInterface
{
    /**
     * @param EmployeeResponseTransfer $employeeResponseTransfer
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     */
    public function add(EmployeeResponseTransfer $employeeResponseTransfer, EmployeeAddressTransfer $employeeAddressTransfer): void;
}