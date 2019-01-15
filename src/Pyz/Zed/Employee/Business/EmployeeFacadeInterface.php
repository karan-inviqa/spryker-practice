<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Business;

use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Generated\Shared\Transfer\EmployeeResponseTransfer;
use Generated\Shared\Transfer\EmployeeTransfer;
use Generated\Shared\Transfer\StateMachineItemTransfer;

/**
 * Interface EmployeeFacadeInterface
 * @package Pyz\Zed\Employee\Business
 */
interface EmployeeFacadeInterface
{
    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     */
    public function registerEmployee(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer;

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeTransfer
     */
    public function getEmployee(EmployeeTransfer $employeeTransfer): EmployeeTransfer;

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     */
    public function updateEmployee(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer;

    /**
     * @param EmployeeResponseTransfer $employeeResponseTransfer
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     */
    public function addEmployeeAddress(EmployeeResponseTransfer $employeeResponseTransfer, EmployeeAddressTransfer $employeeAddressTransfer): void;

    /**
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     * @return array|[]EmployeeAddressTransfer
     */
    public function getEmployeeAddresses(EmployeeAddressTransfer $employeeAddressTransfer): array;

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return StateMachineItemTransfer
     */
    public function getStateMachineItem(EmployeeTransfer $employeeTransfer): StateMachineItemTransfer;

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     * @return EmployeeResponseTransfer
     */
    public function updateEmployeeState(StateMachineItemTransfer $stateMachineItemTransfer): EmployeeResponseTransfer;

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     */
    public function sendEmployeeNotificationEmail(StateMachineItemTransfer $stateMachineItemTransfer):void;
}
