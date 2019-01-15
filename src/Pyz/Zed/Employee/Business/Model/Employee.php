<?php

namespace Pyz\Zed\Employee\Business\Model;


use Generated\Shared\Transfer\EmployeeResponseTransfer;
use Generated\Shared\Transfer\EmployeeTransfer;
use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailSenderTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\StateMachineItemTransfer;
use Orm\Zed\Employee\Persistence\PyzEmployee;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Pyz\Zed\Employee\Dependancy\EmployeeToMailBridge;
use Pyz\Zed\Employee\Persistence\EmployeeQueryContainer;
use Pyz\Zed\Employee\Plugin\Mail\EmployeeNotificationMailTypePlugin;
use Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException;
use Zend\Stdlib\ArrayObject;

/**
 * Class Employee
 * @package Pyz\Zed\Employee\Business\Model
 */
class Employee implements EmployeeInterface
{
    public const UPDATE_EMPLOYEE = 'update';
    public const SENDER_EMAIL = 'karan.popat@inviqa.com';
    public const SENDER_NAME = 'Karan Popat';
    const EMPLOYEE_NOTOFICATION_MAIL_TYPE = 'update_employee';
    /**
     * @var EmployeeQueryContainer
     */
    protected $queryContainer;

    /**
     * @var EmployeeToMailBridge
     */
    protected $mailFacade;


    /**
     * Employee constructor.
     * @param EmployeeQueryContainer $queryContainer
     * @param EmployeeToMailBridge $employeeToMailBridge
     */
    public function __construct(EmployeeQueryContainer $queryContainer, EmployeeToMailBridge $employeeToMailBridge)
    {
        $this->queryContainer = $queryContainer;
        $this->mailFacade = $employeeToMailBridge;
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function add(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer
    {
        $employeeEntity = new PyzEmployee();
        $employeeEntity->fromArray($employeeTransfer->toArray());
        $employeeEntity->save();

        $employeeResponseTransfer = $this->getEmployeeResponseTransfer();
        $employeeResponseTransfer->setIdEmployee($employeeEntity->getIdEmployee());
        $employeeResponseTransfer->setEmail($employeeEntity->getEmail());

        return $employeeResponseTransfer;
    }

    /**
     * @return EmployeeResponseTransfer
     */
    private function getEmployeeResponseTransfer(): EmployeeResponseTransfer
    {
        $employeeResponseTransfer = new  EmployeeResponseTransfer();
        return $employeeResponseTransfer;
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeTransfer
     * @throws AmbiguousComparisonException
     * @throws EntityNotFoundException
     */
    public function get(EmployeeTransfer $employeeTransfer): EmployeeTransfer
    {
        $employeeEntity = $this->getEmployee($employeeTransfer);
        $employeeTransfer->fromArray($employeeEntity->toArray());

        return $employeeTransfer;
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return PyzEmployee
     * @throws AmbiguousComparisonException
     * @throws EntityNotFoundException
     */
    protected function getEmployee(EmployeeTransfer $employeeTransfer): PyzEmployee
    {
        $employeeEntity = null;

        if ($employeeTransfer->getIdEmployee()) {
            $employeeEntity = $this->queryContainer->queryEmployeeById($employeeTransfer->getIdEmployee())->findOne();
        } elseif ($employeeTransfer->getEmail()) {
            $employeeEntity = $this->queryContainer->queryEmployeeByEmail($employeeTransfer->getEmail())->findOne();
        }

        if ($employeeEntity) {
            return $employeeEntity;
        }

        throw new EntityNotFoundException(sprintf(
            'Employee not found by either ID `%s`or email `%s`.',
            $employeeTransfer->getIdEmployee(),
            $employeeTransfer->getEmail()
        ));
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return EmployeeResponseTransfer
     * @throws AmbiguousComparisonException
     * @throws EntityNotFoundException
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function update(EmployeeTransfer $employeeTransfer): EmployeeResponseTransfer
    {
        $employeeEntity = $this->getEmployee($employeeTransfer);
        $employeeEntity->fromArray($employeeTransfer->modifiedToArray());

        $employeeEntity->save();

        $employeeResponseTransfer = $this->getEmployeeResponseTransfer();
        $employeeResponseTransfer->setIdEmployee($employeeEntity->getIdEmployee());
        $employeeResponseTransfer->setEmail($employeeEntity->getEmail());

        return $employeeResponseTransfer;
    }

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     * @return EmployeeResponseTransfer
     * @throws AmbiguousComparisonException
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function updateEmployeeState(StateMachineItemTransfer $stateMachineItemTransfer): EmployeeResponseTransfer
    {
        $employeeEntity = $this->queryContainer->queryEmployeeById($stateMachineItemTransfer->getIdentifier())->findOne();
        $employeeEntity->setFkEmployeeState($stateMachineItemTransfer->getIdItemState());

        $employeeEntity->save();

        $employeeResponseTransfer = $this->getEmployeeResponseTransfer();
        $employeeResponseTransfer->setIdEmployee($employeeEntity->getIdEmployee());
        $employeeResponseTransfer->setEmail($employeeEntity->getEmail());

        return $employeeResponseTransfer;
    }

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     * @throws AmbiguousComparisonException
     */
    public function sendEmail(StateMachineItemTransfer $stateMachineItemTransfer):void
    {
        $mailTransfer = new MailTransfer();
        $mailRecipantTransfer = $this->getRecipantTransfer($stateMachineItemTransfer);
        $mailTransfer->addRecipient($mailRecipantTransfer);
        $mailTransfer->setType(EmployeeNotificationMailTypePlugin::MAIL_TYPE);
        $this->mailFacade->handleMail($mailTransfer);
    }

    /**
     * @param StateMachineItemTransfer $stateMachineItemTransfer
     * @return MailRecipientTransfer
     * @throws AmbiguousComparisonException
     */
    private function getRecipantTransfer(StateMachineItemTransfer $stateMachineItemTransfer):MailRecipientTransfer
    {
        $mailRecipantTransfer = new MailRecipientTransfer();
        $mailRecipantTransfer->setType(static::EMPLOYEE_NOTOFICATION_MAIL_TYPE);

        try{
            $employee = $this->queryContainer->queryEmployeeById($stateMachineItemTransfer->getIdentifier())->findOne();
            $mailRecipantTransfer->setEmail($employee->getEmail());
            $mailRecipantTransfer->setName( $employee->getFirstName()." ".$employee->getLastName());
        } catch (\Spryker\Zed\Api\Business\Exception\EntityNotFoundException $entityNotFoundException) {
            echo "Sorry, we could not find employee.";
        }
        return $mailRecipantTransfer;
    }
}