<?php


namespace Pyz\Zed\Employee\Business\Model;


use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Generated\Shared\Transfer\EmployeeResponseTransfer;
use Orm\Zed\Employee\Persistence\PyzEmployeeAddress;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Pyz\Zed\Employee\Persistence\EmployeeQueryContainer;

/**
 * Class EmployeeAddress
 * @package Pyz\Zed\Employee\Business\Model
 */
class EmployeeAddress implements EmployeeAddressInterface
{

    protected $queryContainer;

    /**
     * EmployeeAddress constructor.
     * @param EmployeeQueryContainer $queryContainer
     */
    public function __construct(EmployeeQueryContainer $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @param EmployeeResponseTransfer $employeeResponseTransfer
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function add(EmployeeResponseTransfer $employeeResponseTransfer, EmployeeAddressTransfer $employeeAddressTransfer): void
    {
        $employeeAddressEntity = new PyzEmployeeAddress();
        $employeeAddressEntity->fromArray($employeeAddressTransfer->toArray());
        $employeeAddressEntity->setFkEmployee($employeeResponseTransfer->getIdEmployee());
        $employeeAddressEntity->save();
    }

    /**
     * @param EmployeeAddressTransfer $employeeAddressTransfer
     * @return array|[]$employeeAddressEntity
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function getAddresses(EmployeeAddressTransfer $employeeAddressTransfer): array
    {
        $addresses = [];
        try {
            $employeeAddressEntities = $this->queryContainer->queryAddressByIdEmploye($employeeAddressTransfer)->find();
            foreach ($employeeAddressEntities as $employeeAddressEntity) {
                $addresses[] = $employeeAddressEntity;
            }
        } catch (EntityNotFoundException $e) {
            echo "We could not found any address for this employee.";
        }

        return $addresses;
    }
}