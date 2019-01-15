<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Persistence;

use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Orm\Zed\Employee\Persistence\PyzEmployeeAddressQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

/**
 * Interface EmployeeQueryContainerInterface
 * @package Pyz\Zed\Employee\Persistence
 */
interface EmployeeQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @api
     *
     * @param string $email
     *
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeQuery
     */
    public function queryEmployeeByEmail($email);

    /**
     * @api
     *
     * @param int $id
     *
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeQuery
     */
    public function queryEmployeeById($id);

    /**
     * @api
     *
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeQuery
     */
    public function queryEmployees();

    /**
     * @return mixed
     */
    public function getEmployeeAddresses();

    /**
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     * @return PyzEmployeeAddressQuery
     */
    public function queryAddressByIdEmploye(EmployeeAddressTransfer $employeeAddressTransfer): PyzEmployeeAddressQuery;
}
