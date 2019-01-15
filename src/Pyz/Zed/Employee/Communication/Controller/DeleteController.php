<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2018-12-26
 * Time: 11:39
 */

namespace Pyz\Zed\Employee\Communication\Controller;


use Generated\Shared\Transfer\EmployeeTransfer;
use Orm\Zed\Employee\Persistence\PyzEmployee;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Employee\Communication\EmployeeCommunicationFactory getFactory()
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Employee\Business\EmployeeFacadeInterface getFacade()
 */
class DeleteController extends AbstractController
{
    const ID_EMPLOYEE = 'id-employee';

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $idEmployee = $this->castId($request->get(self::ID_EMPLOYEE));

        $employeeTransfer = new EmployeeTransfer();
        $employeeTransfer->setIdEmployee($idEmployee);

        try {
            $employeeTransfer = $this->getFacade()->getEmployee($employeeTransfer);
        } catch (EntityNotFoundException $exception) {
            $this->addErrorMessage('Employee does not exist');
            return $this->redirectResponse('/employee');
        }

        return $this->viewResponse([
            'idEmployee' => $employeeTransfer->getIdEmployee(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function confirmAction(Request $request)
    {
        $idEmployee = $this->castId($request->get(self::ID_EMPLOYEE));

        $employeeTransfer = new EmployeeTransfer();
        $employeeTransfer->setIdEmployee($idEmployee);

        $employeeEntity = new PyzEmployee();
        $employeeEntity->fromArray($employeeTransfer->toArray());


        try {
            $employeeEntity->delete();
        } catch (EntityNotFoundException $exception) {
            $this->addErrorMessage('Employee does not exist');
            return $this->redirectResponse('/employee');
        }

        $this->addSuccessMessage('Employee successfully deleted');
        return $this->redirectResponse('/employee');
    }
}