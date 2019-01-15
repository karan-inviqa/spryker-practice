<?php

namespace Pyz\Zed\Employee\Communication\Controller;


use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Generated\Shared\Transfer\EmployeeTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Employee\Communication\EmployeeCommunicationFactory getFactory()
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Employee\Business\EmployeeFacadeInterface getFacade()
 */
class ViewController extends AbstractController
{
    const ID_EMPLOYEE = 'id-employee';

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function indexAction(Request $request)
    {
        $idEmployee = $request->get(self::ID_EMPLOYEE);

        if (!$idEmployee) {
            return $this->redirectResponse('/employee');
        }

        $idEmployee = $this->castId($idEmployee);
        $employeeTransfer = $this->loadEmployeeTransfer($idEmployee);
        $employeeAddressTransfer = $this->loadEmployeeAddressTransfer($idEmployee);

        $manualEvents = $this->getEmployeeStateMachineManualEvents($employeeTransfer);

        return $this->viewResponse([
            'employee' => $employeeTransfer,
            'employeeAddresses' => $employeeAddressTransfer,
            'idEmployee' => $idEmployee,
            'manualEvents' => $manualEvents
        ]);

    }

    /**
     * @param int $idEmployee
     * @return EmployeeTransfer
     */
    private function loadEmployeeTransfer(int $idEmployee): EmployeeTransfer
    {
        $employeeTransfer = $this->createEmployeeTransfer();
        $employeeTransfer->setIdEmployee($idEmployee);
        $employeeTransfer = $this->getFacade()->getEmployee($employeeTransfer);

        return $employeeTransfer;
    }

    /**
     * @return EmployeeTransfer
     */
    private function createEmployeeTransfer(): EmployeeTransfer
    {
        return new EmployeeTransfer();
    }


    /**
     * @param int $idEmployee
     * @return array|[]EmployeeAddressTransfer
     */
    private function loadEmployeeAddressTransfer(int $idEmployee): array
    {
        $employeeAddressTransfer = $this->createEmployeeAddressTransfer();
        $employeeAddressTransfer->setFkEmployee($idEmployee);
        $employeeAddressTransfer = $this->getFacade()->getEmployeeAddresses($employeeAddressTransfer);
        return $employeeAddressTransfer;
    }

    private function createEmployeeAddressTransfer(): EmployeeAddressTransfer
    {
        return new EmployeeAddressTransfer();
    }

    /**
     * @param EmployeeTransfer $employeeTransfer
     * @return array of manual events
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    private function getEmployeeStateMachineManualEvents(EmployeeTransfer $employeeTransfer):array
    {
        $stateMachineItemTransfer = $this->getFacade()->getStateMachineItem($employeeTransfer);
        $stateMachineItemTransfer = $this->getFactory()->getStateMachineFacade()->getProcessedStateMachineItemTransfer($stateMachineItemTransfer);
        $manualEvents = $this->getFactory()->getStateMachineFacade()->getManualEventsForStateMachineItem($stateMachineItemTransfer);

        return $manualEvents;
    }
}