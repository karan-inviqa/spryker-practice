<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Persistence;

use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Orm\Zed\Employee\Persistence\PyzEmployeeAddressQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\Employee\Persistence\EmployeePersistenceFactory getFactory()
 */
class EmployeeQueryContainer extends AbstractQueryContainer implements EmployeeQueryContainerInterface
{
    /**
     * @api
     *
     * @param string $email
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeQuery
     */
    public function queryEmployeeByEmail($email)
    {
        return $this->queryEmployees()->filterByEmail($email);
    }

    /**
     * @api
     *
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeQuery
     */
    public function queryEmployees()
    {
        return $this->getFactory()->createPyzEmployeeQuery();
    }

    /**
     * @api
     *
     * @param int $id
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeQuery
     */
    public function queryEmployeeById($id)
    {
        return $this->queryEmployees()->filterByIdEmployee($id);
    }

    /**
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeAddressQuery
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function queryAddressByIdEmploye(EmployeeAddressTransfer $employeeAddressTransfer): PyzEmployeeAddressQuery
    {
        return $this->getEmployeeAddresses()->filterByFkEmployee($employeeAddressTransfer->getFkEmployee());
    }

    /**
     * @param \Generated\Shared\Transfer\EmployeeAddressTransfer $employeeAddressTransfer
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeAddressQuery
     */
    public function getEmployeeAddresses()
    {
        return $this->getFactory()->createPyzEmployeeAddressQuery();
    }
}
