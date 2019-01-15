<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2018-12-19
 * Time: 11:05
 */

namespace Pyz\Zed\Employee\Business\Model;


use Generated\Shared\Transfer\EmployeeResponseTransfer;
use Generated\Shared\Transfer\EmployeeTransfer;
use Generated\Shared\Transfer\StateMachineItemTransfer;

/**
 * Interface EmployeeInterface
 * @package Pyz\Zed\Employee\Business\Model
 */
interface EmployeeInterface
{
    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     */
    public function add(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer;

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeTransfer
     */
    public function get(EmployeeTransfer $employeeTransfer): EmployeeTransfer;

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     */
    public function update(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer;

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     * @return EmployeeResponseTransfer
     */
    public function updateEmployeeState(StateMachineItemTransfer $stateMachineItemTransfer): EmployeeResponseTransfer;
}