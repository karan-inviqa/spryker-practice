<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Persistence;

use Orm\Zed\Employee\Persistence\PyzEmployeeAddressQuery;
use Orm\Zed\Employee\Persistence\PyzEmployeeQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Employee\EmployeeConfig getConfig()
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainer getQueryContainer()
 */
class EmployeePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return PyzEmployeeQuery
     */
    public function createPyzEmployeeQuery(): PyzEmployeeQuery
    {
        return PyzEmployeeQuery::create();
    }

    /**
     * @return PyzEmployeeAddressQuery
     */
    public function createPyzEmployeeAddressQuery(): PyzEmployeeAddressQuery
    {
        return PyzEmployeeAddressQuery::create();
    }
}
