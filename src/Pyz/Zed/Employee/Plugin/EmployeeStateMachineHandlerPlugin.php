<?php

namespace Pyz\Zed\Employee\Plugin;

use Generated\Shared\Transfer\StateMachineItemTransfer;
use Pyz\Zed\Employee\Business\EmployeeFacadeInterface;
use Pyz\Zed\Employee\Plugin\Command\EmployeeApprovedPlugin;
use Pyz\Zed\Employee\Plugin\Command\EmployeeBlockedPlugin;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\StateMachine\Dependency\Plugin\StateMachineHandlerInterface;


/**
 * Class EmployeeStateMachineHandlerPlugin
 * @package Pyz\Zed\Employee\Plugin
 * @method EmployeeFacadeInterface getFacade()
 */
class EmployeeStateMachineHandlerPlugin extends AbstractPlugin implements StateMachineHandlerInterface
{
    public const STATE_MACHINE_NAME = "Employee";
    public const ACTIVE_PROCESS = "Employee01";
    public const INITIAL_STATE = 'new';

    /**
     * List of command plugins for this state machine for all processes. Array key is identifier in SM xml file.
     *
     * [
     *   'Command/Plugin' => new Command(),
     *   'Command/Plugin2' => new Command2(),
     * ]
     *
     * @api
     *
     * @return array
     */
    public function getCommandPlugins()
    {
        return [
            'Employee/Approved' => new EmployeeApprovedPlugin(),
            'Employee/Blocked' => new EmployeeBlockedPlugin(),
        ];
    }

    /**
     * List of condition plugins for this state machine for all processes. Array key is identifier in SM xml file.
     *
     *  [
     *   'Condition/Plugin' => new Condition(),
     *   'Condition/Plugin2' => new Condition2(),
     * ]
     *
     * @api
     *
     * @return array
     */
    public function getConditionPlugins()
    {
        return [];
    }

    /**
     * Name of state machine used by this handler.
     *
     * @api
     *
     * @return string
     */
    public function getStateMachineName()
    {
        return static::STATE_MACHINE_NAME;
    }

    /**
     * List of active processes used for this state machine.
     *
     * [
     *   'ProcessName',
     *   'ProcessName2 ,
     * ]
     *
     * @api
     *
     * @return string[]
     */
    public function getActiveProcesses()
    {
        return [
            static::ACTIVE_PROCESS,
        ];
    }

    /**
     * Provide initial state name for item when state machine initialized. Using process name.
     *
     * @api
     *
     * @param string $processName
     *
     * @return string
     */
    public function getInitialStateForProcess($processName)
    {
        return static::INITIAL_STATE;
    }

    /**
     * This method is called when state of item was changed, client can create custom logic for example update it's related table with new stateId and processId.
     * StateMachineItemTransfer:identifier is id of entity from client.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\StateMachineItemTransfer $stateMachineItemTransfer
     *
     * @return bool
     */
    public function itemStateUpdated(StateMachineItemTransfer $stateMachineItemTransfer)
    {
        $employeeUpdate = $this->getFacade()->updateEmployeeState($stateMachineItemTransfer);
        // TODO: Implement itemStateUpdated() method.
    }

    /**
     * This method should return all list of StateMachineItemTransfer, with (identifier, IdStateMachineProcess, IdItemState)
     *
     * @api
     *
     * @param int[] $stateIds
     *
     * @return \Generated\Shared\Transfer\StateMachineItemTransfer[]
     */
    public function getStateMachineItemsByStateIds(array $stateIds = [])
    {
        // TODO: Implement getStateMachineItemsByStateIds() method.
    }
}