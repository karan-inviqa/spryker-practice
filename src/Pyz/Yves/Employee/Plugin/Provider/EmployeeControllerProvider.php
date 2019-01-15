<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Employee\Plugin\Provider;

use Pyz\Yves\Application\Plugin\Provider\AbstractYvesControllerProvider;
use Silex\Application;

class EmployeeControllerProvider extends AbstractYvesControllerProvider
{
    public const EMPLOYEE_INDEX = 'employee-index';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    protected function defineControllers(Application $app)
    {
        $this->createGetController('/employee', static::EMPLOYEE_INDEX, 'Employee', 'Index', 'index');
    }
}
