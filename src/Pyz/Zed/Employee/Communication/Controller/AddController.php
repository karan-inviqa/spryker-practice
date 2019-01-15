<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Communication\Controller;

use Generated\Shared\Transfer\EmployeeAddressTransfer;
use Generated\Shared\Transfer\EmployeeCreationFormTransfer;
use Generated\Shared\Transfer\EmployeeResponseTransfer;
use Generated\Shared\Transfer\EmployeeTransfer;
use Generated\Shared\Transfer\StateMachineProcessTransfer;
use Pyz\Zed\Employee\Plugin\EmployeeStateMachineHandlerPlugin;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Employee\Communication\EmployeeCommunicationFactory getFactory()
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Employee\Business\EmployeeFacadeInterface getFacade()
 */
class AddController extends AbstractController
{
    public const MESSAGE_EMPLOYEE_CREATE_SUCCESS = 'Employee was created successfully.';
    public const MESSAGE_EMPLOYEE_CREATE_ERROR = 'Employee was not created.';
    public const REDIRECT_URL_DEFAULT = '/employee';
    public const REDIRECT_URL_KEY = 'redirectUrl';

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Spryker\Service\UtilText\Model\Url\UrlInvalidException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function indexAction(Request $request)
    {
        $employeeCreationFormTransfer = new EmployeeCreationFormTransfer();

        $baseRedirectUrl = urldecode($request->query->get(static::REDIRECT_URL_KEY, static::REDIRECT_URL_DEFAULT));

        $employeedataProvider = $this->getFactory()->createEmployeeFormDataProvider();
        $addressesDataProvider = $this->getFactory()->createEmployeeAddressesDataProvider();

        $employeeForm = $this->getFactory()
            ->createEmployeeForm(
                $employeedataProvider->getData(),
                array_merge(
                    $employeedataProvider->getOptions(),
                    [
                        'action' => Url::generate('/employee/add', [static::REDIRECT_URL_KEY => $baseRedirectUrl]),
                    ]
                )
            );
        $employeeForm->setData($employeeCreationFormTransfer->getEmployee());
        $employeeForm->handleRequest($request);
        $employeeCreationFormTransfer->setEmployee($employeeForm->getData());

        $employeeAddressForm = $this->getFactory()->createEmployeeAddressesForm($addressesDataProvider->getData($employeeCreationFormTransfer), $addressesDataProvider->getOptions());
        $employeeAddressForm->setData($employeeCreationFormTransfer);
        $employeeAddressForm->handleRequest($request);
        $employeeCreationFormTransfer->setAddresses($employeeAddressForm->getData()->getAddresses());

        if ($employeeForm->isSubmitted() && $employeeForm->isValid() && $employeeAddressForm->isValid()) {
            $employeeTransfer = new EmployeeTransfer();
            $employeeTransfer->fromArray($employeeForm->getData()->toArray(), true);
            $employeeResponseTransfer = $this->getFacade()->registerEmployee($employeeTransfer);

            $employeeAddressTransfer = new EmployeeAddressTransfer();
            foreach ($employeeAddressForm->getData()->getAddresses() as $address) {
                $employeeAddressTransfer->fromArray($address->toArray(), true);
                $employeeAddressResponseTransfer = $this->getFacade()->addEmployeeAddress($employeeResponseTransfer, $employeeAddressTransfer);

            }
            $this->triggerStateMachineForNewEmployee($employeeResponseTransfer);
            $this->getFacade()->updateEmployee($employeeTransfer);
            $this->addSuccessMessage(static::MESSAGE_EMPLOYEE_CREATE_SUCCESS);
            return $this->redirectResponse($this->getSuccessRedirectUrl($baseRedirectUrl));
        }

        return $this->viewResponse([
            'employeeForm' => $employeeForm->createView(),
            'employeeAddressForm' => $employeeAddressForm->createView(),
        ]);
    }

    /**
     * @param EmployeeResponseTransfer $employeeResponseTransfer
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    private function triggerStateMachineForNewEmployee(EmployeeResponseTransfer $employeeResponseTransfer)
    {
        $stateMachineProcessTransfer = new StateMachineProcessTransfer();
        $stateMachineProcessTransfer->setProcessName(EmployeeStateMachineHandlerPlugin::ACTIVE_PROCESS);
        $stateMachineProcessTransfer->setStateMachineName(EmployeeStateMachineHandlerPlugin::STATE_MACHINE_NAME);

        $stateMachineFacade = $this->getFactory()->getStateMachineFacade();

        $items = $stateMachineFacade->triggerForNewStateMachineItem(
            $stateMachineProcessTransfer,
            $employeeResponseTransfer->getIdEmployee()
        );

    }

    /**
     * @param string $baseRedirectUrl
     * @return string
     * @throws \Spryker\Service\UtilText\Model\Url\UrlInvalidException
     */
    protected function getSuccessRedirectUrl(string $baseRedirectUrl): string
    {
        $redirectUrl = Url::parse($baseRedirectUrl);

        return $redirectUrl->build();
    }
}
