<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2019-01-08
 * Time: 18:54
 */

namespace Pyz\Zed\Employee\Plugin\Command;


use Generated\Shared\Transfer\StateMachineItemTransfer;
use Pyz\Zed\Employee\Business\EmployeeFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\StateMachine\Dependency\Plugin\CommandPluginInterface;

/**
 * Class EmployeeBlockedPlugin
 * @package Pyz\Zed\Employee\Plugin\Command
 * @method EmployeeFacadeInterface getFacade()
 */
class EmployeeBlockedPlugin extends AbstractPlugin implements CommandPluginInterface
{

    /**
     * EmployeeBlockedPlugin constructor.
     */
    public function __construct()
    {
    }

    public function run(StateMachineItemTransfer $stateMachineItemTransfer):void
    {
        $this->getFacade()->sendEmployeeNotificationEmail($stateMachineItemTransfer);
    }
}