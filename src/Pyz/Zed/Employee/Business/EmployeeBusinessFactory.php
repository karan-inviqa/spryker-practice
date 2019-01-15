<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Business;

use Pyz\Zed\Employee\Business\Model\Employee;
use Pyz\Zed\Employee\Business\Model\EmployeeAddress;
use Pyz\Zed\Employee\Business\Model\EmployeeStateMachineReader;
use Pyz\Zed\Employee\EmployeeDependencyProvider;
use Pyz\Zed\Employee\Persistence\EmployeeAddressQueryContainer;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\Employee\EmployeeConfig getConfig()
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface getQueryContainer()
 */
class EmployeeBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return Employee
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createEmployee():Employee
    {
        return new Employee($this->getQueryContainer(), $this->getMailFacade());
    }

    /**
     * @return EmployeeAddress
     */
    public function createEmployeeAddress():EmployeeAddress
    {
        return new EmployeeAddress($this->getQueryContainer());
    }

    /**
     * @return EmployeeStateMachineReader
     */
    public function createEmployeeStateMachineItems():EmployeeStateMachineReader
    {
        return new EmployeeStateMachineReader($this->getQueryContainer());
    }


    /**
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    private function getMailFacade()
    {
        return $this->getProvidedDependency(EmployeeDependencyProvider::FACADE_MAIL);
    }
}
