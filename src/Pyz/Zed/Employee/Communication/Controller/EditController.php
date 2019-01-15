<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2018-12-21
 * Time: 14:57
 */

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
class EditController extends AbstractController
{
    public const ID_EMPLOYEE = 'id-employee';
    public const MESSAGE_EMPLOYEE_UPDATE_SUCCESS = "Employee updated sucsessfully!";
    public const REDIRECT_URL_DEFAULT = '/employee';
    public const REDIRECT_URL_KEY = 'redirectUrl';

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     * @throws \Spryker\Service\UtilText\Model\Url\UrlInvalidException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function indexAction(Request $request)
    {
        $baseRedirectUrl = urldecode($request->query->get(static::REDIRECT_URL_KEY, static::REDIRECT_URL_DEFAULT));
        $idEmployee = $this->castId($request->query->get(self::ID_EMPLOYEE));
        /**
         * Employee date provider and update form
         */
        $employeeDataProvider = $this->getFactory()->createEmployeeUpdateFormDataProvider();
        $employeeForm = $this->getFactory()->createEmployeeUpdateForm(
            $employeeDataProvider->getData($idEmployee),
            $employeeDataProvider->getOptions($idEmployee)
        )->handleRequest($request);

        /**
         * EmployeeAddressDataProvider and update form
         */
        $employeeAddresTransfer = $this->getEmployeeAddressTransfer();
        $employeeAddressDataProvider = $this->getFactory()->createEmployeeAddressUpdateFormDataProvider();
        $employeeAddressForm = $this->getFactory()->createEmployeeAddressUpdateForm(
            $employeeAddressDataProvider->getData($employeeAddresTransfer->setFkEmployee($idEmployee)),
            $employeeAddressDataProvider->getOptions($idEmployee)
        )->handleRequest($request);

        if ($employeeForm->isSubmitted() && $employeeForm->isValid() && $employeeAddressForm->isValid()) {
            $employeeTransfer = new EmployeeTransfer();
            $employeeTransfer->fromArray($employeeForm->getData(), true);

            $employeeResponseTransfer = $this->getFacade()->updateEmployee($employeeTransfer);

            $this->addSuccessMessage(static::MESSAGE_EMPLOYEE_UPDATE_SUCCESS);
            return $this->redirectResponse($this->getSuccessRedirectUrl($baseRedirectUrl));
        }

        return $this->viewResponse([
            'employeeForm' => $employeeForm->createView(),
            'employeeAddressForm' => $employeeAddressForm->createView(),
            'idEmployee' => $idEmployee
        ]);
    }

    private function getEmployeeAddressTransfer(): EmployeeAddressTransfer
    {
        return new EmployeeAddressTransfer();
    }

    /**
     * @param string $baseRedirectUrl
     * @return string
     */
    protected function getSuccessRedirectUrl(string $baseRedirectUrl): string
    {
        $redirectUrl = Url::parse($baseRedirectUrl);

        return $redirectUrl->build();
    }
}