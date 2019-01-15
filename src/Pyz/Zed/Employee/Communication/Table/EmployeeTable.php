<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Communication\Table;

use Orm\Zed\Employee\Persistence\Map\PyzEmployeeTableMap;
use Orm\Zed\Employee\Persistence\PyzEmployee;
use Orm\Zed\Employee\Persistence\PyzEmployeeQuery;
use Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class EmployeeTable extends AbstractTable
{
    public const ACTIONS = 'Actions';

    public const COL_CREATED_AT = 'created_at';
    public const COL_ID_EMPLOYEE = 'id_employee';
    public const COL_EMAIL = 'email';
    public const COL_FIRST_NAME = 'first_name';
    public const COL_LAST_NAME = 'last_name';
    public const COL_GENDER = 'gender';

    protected $employeeQueryContainerInterface;

    /**
     * @param \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface $employeeQueryContainerInterface
     */
    public function __construct(
        EmployeeQueryContainerInterface $employeeQueryContainerInterface
    )
    {
        $this->employeeQueryContainerInterface = $employeeQueryContainerInterface;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config)
    {
        $config->setHeader([
            self::COL_ID_EMPLOYEE => '#',
            self::COL_CREATED_AT => 'Joining Date',
            self::COL_EMAIL => 'Email',
            self::COL_LAST_NAME => 'Last Name',
            self::COL_FIRST_NAME => 'First Name',
            self::COL_GENDER => "Gender",
            self::ACTIONS => self::ACTIONS,
        ]);

        $config->addRawColumn(self::ACTIONS);

        $config->setSortable([
            self::COL_ID_EMPLOYEE,
            self::COL_CREATED_AT,
            self::COL_EMAIL,
            self::COL_LAST_NAME,
            self::COL_FIRST_NAME,
            self::COL_GENDER
        ]);

        $config->setUrl('table');

        $config->setSearchable([
            PyzEmployeeTableMap::COL_ID_EMPLOYEE,
            PyzEmployeeTableMap::COL_EMAIL,
            PyzEmployeeTableMap::COL_CREATED_AT,
            PyzEmployeeTableMap::COL_FIRST_NAME,
            PyzEmployeeTableMap::COL_LAST_NAME,
            PyzEmployeeTableMap::COL_GENDER
        ]);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $query = $this->prepareQuery();
        $employeeCollection = $this->runQuery($query, $config, true);

        if ($employeeCollection->count() < 1) {
            return [];
        }

        return $this->formatEmployeeCollection($employeeCollection);
    }

    /**
     * @return \Orm\Zed\Employee\Persistence\PyzEmployeeQuery
     */
    protected function prepareQuery(): PyzEmployeeQuery
    {
        return $this->employeeQueryContainerInterface->queryEmployees();
    }

    /**
     * @param $employeeCollection
     * @return array
     */
    private function formatEmployeeCollection($employeeCollection): array
    {
        $employeeList = [];

        foreach ($employeeCollection as $employee) {
            $employeeList[] = $this->hydrateEmployeeListRow($employee);
        }

        return $employeeList;
    }

    /**
     * @param $employee
     * @return array
     */
    private function hydrateEmployeeListRow($employee): array
    {
        $employeeRow = $employee->toArray();
        $employeeRow[self::ACTIONS] = $this->buildLinks($employee);

        return $employeeRow;
    }

    /**
     * @param PyzEmployee|null $employee
     * @return string
     */
    protected function buildLinks(?PyzEmployee $employee = null): string
    {
        if ($employee === null) {
            return '';
        }

        $buttons = [];
        $buttons[] = $this->generateViewButton('/employee/view?id-employee=' . $employee->getIdEmployee(), 'View');
        $buttons[] = $this->generateEditButton('/employee/edit?id-employee=' . $employee->getIdEmployee(), 'Edit');
        $buttons[] = $this->generateRemoveButton('/employee/delete?id-employee=' . $employee->getIdEmployee(), 'Delete');

        return implode(' ', $buttons);
    }
}

