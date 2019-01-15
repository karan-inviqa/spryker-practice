<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Employee;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\Employee\EmployeeFactory getFactory()
 */
class EmployeeClient extends AbstractClient implements EmployeeClientInterface
{
    /**
     * @return \Pyz\Client\Employee\Zed\EmployeeStubInterface
     */
    protected function getZedStub()
    {
        return $this->getFactory()->createZedStub();
    }
}
