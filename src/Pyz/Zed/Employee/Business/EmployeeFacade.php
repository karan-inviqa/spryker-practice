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
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Employee\Business\EmployeeBusinessFactory getFactory()
 */
class EmployeeFacade extends AbstractFacade implements EmployeeFacadeInterface
{
    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function registerEmployee(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer
    {
        return $this->getFactory()->createEmployee()->add($employeeTransfer);
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeTransfer
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getEmployee(EmployeeTransfer $employeeTransfer): EmployeeTransfer
    {
        return $this->getFactory()->createEmployee()->get($employeeTransfer);
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function updateEmployee(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer
    {
        return $this->getFactory()->createEmployee()->update($employeeTransfer);
    }

    /**
     * @param EmployeeResponseTransfer $employeeResponseTransfer
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function addEmployeeAddress(EmployeeResponseTransfer $employeeResponseTransfer, EmployeeAddressTransfer $employeeAddressTransfer): void
    {
        $this->getFactory()->createEmployeeAddress()->add($employeeResponseTransfer, $employeeAddressTransfer);
    }

    /**
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     * @return array|[]EmployeeAddressTransfer
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getEmployeeAddresses(EmployeeAddressTransfer $employeeAddressTransfer): array
    {
        return $this->getFactory()->createEmployeeAddress()->getAddresses($employeeAddressTransfer);
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return StateMachineItemTransfer
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getStateMachineItem(EmployeeTransfer $employeeTransfer): StateMachineItemTransfer
    {
        return $this->getFactory()->createEmployeeStateMachineItems()->getStateMachineItem($employeeTransfer);
    }

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     * @return EmployeeResponseTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function updateEmployeeState(StateMachineItemTransfer $stateMachineItemTransfer): EmployeeResponseTransfer
    {
        return $this->getFactory()->createEmployee()->updateEmployeeState($stateMachineItemTransfer);
    }

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     */
    public function sendEmployeeNotificationEmail(StateMachineItemTransfer $stateMachineItemTransfer): void
    {
        $this->getFactory()->createEmployee()->sendEmail($stateMachineItemTransfer);
    }
}
