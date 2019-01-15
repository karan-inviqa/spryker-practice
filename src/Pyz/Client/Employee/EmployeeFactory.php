<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Employee;

use Pyz\Client\Employee\Zed\EmployeeStub;
use Spryker\Client\Kernel\AbstractFactory;

class EmployeeFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Client\Employee\Zed\EmployeeStubInterface
     */
    public function createZedStub()
    {
        return new EmployeeStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(EmployeeDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
