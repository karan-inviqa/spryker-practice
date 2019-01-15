<?php

namespace Pyz\Zed\Employee\Business\Model;


use Generated\Shared\Transfer\EmployeeTransfer;
use Generated\Shared\Transfer\StateMachineItemTransfer;
use Orm\Zed\Employee\Persistence\Base\PyzEmployee;
use Pyz\Zed\Employee\Persistence\EmployeeQueryContainer;

/**
 * Class EmployeeStateMachineReader
 * @package Pyz\Zed\Employee\Business\Model
 */
class EmployeeStateMachineReader
{

    /**
     * @var EmployeeQueryContainer
     */
    protected $queryContainer;

    /**
     * EmployeeStateMachineReader constructor.
     * @param EmployeeQueryContainer $getQueryContainer
     */
    public function __construct(EmployeeQueryContainer $getQueryContainer)
    {
        $this->queryContainer = $getQueryContainer;
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return StateMachineItemTransfer
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getStateMachineItem(EmployeeTransfer $employeeTransfer): StateMachineItemTransfer
    {
        $pyzEmployee = $this->queryContainer->queryEmployeeById($employeeTransfer->getIdEmployee())->findOne();
        return $this->hydrateTransferFromPersistence($pyzEmployee);
    }

    /**
     * @param PyzEmployee $pyzEmployee
     * @return StateMachineItemTransfer
     */
    private function hydrateTransferFromPersistence(PyzEmployee $pyzEmployee): StateMachineItemTransfer
    {
        $stateMachineItemTransfer = new StateMachineItemTransfer();
        if ($pyzEmployee->getFkEmployeeState()) {
            $stateMachineItemTransfer->setIdentifier($pyzEmployee->getIdEmployee());
            $stateMachineItemTransfer->setIdItemState($pyzEmployee->getFkEmployeeState());
        }
        return $stateMachineItemTransfer;
    }
}