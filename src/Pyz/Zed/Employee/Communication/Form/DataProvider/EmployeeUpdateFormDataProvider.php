<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2018-12-24
 * Time: 12:11
 */

namespace Pyz\Zed\Employee\Communication\Form\DataProvider;

use Pyz\Zed\Employee\Persistence\EmployeeQueryContainer;

class EmployeeUpdateFormDataProvider extends EmployeeFormDataProvider
{

    /**
     * @var EmployeeQueryContainer
     */
    protected $queryContainer;

    /**
     * EmployeeUpdateFormProvider constructor.
     * @param EmployeeQueryContainer $queryContainer
     */
    public function __construct(EmployeeQueryContainer $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param int|null $idEmployee
     *
     * @return array
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getData($idEmployee = null)
    {
        if ($idEmployee === null) {
            return parent::getData();
        }

        $employeeEntity = $this
            ->queryContainer
            ->queryEmployeeById($idEmployee)
            ->findOne();

        $data = $employeeEntity->toArray();

        return $data;
    }

    /**
     * @param int|null $idEmployee
     *
     * @return array
     */
    public function getOptions($idEmployee = null)
    {
        $options = parent::getOptions();

        return $options;
    }
}