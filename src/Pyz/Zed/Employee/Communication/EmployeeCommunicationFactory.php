<?php

namespace Pyz\Zed\Employee\Communication;

use Generated\Shared\Transfer\EmployeeCreationFormTransfer;
use Generated\Shared\Transfer\EmployeeTransfer;
use Pyz\Zed\Employee\Communication\Form\Addresses;
use Pyz\Zed\Employee\Communication\Form\DataProvider\EmployeeAddressesDataProvider;
use Pyz\Zed\Employee\Communication\Form\DataProvider\EmployeeAddressFormDataProvider;
use Pyz\Zed\Employee\Communication\Form\DataProvider\EmployeeAddressUpdateFormProvider;
use Pyz\Zed\Employee\Communication\Form\DataProvider\EmployeeFormDataProvider;
use Pyz\Zed\Employee\Communication\Form\DataProvider\EmployeeUpdateFormDataProvider;
use Pyz\Zed\Employee\Communication\Form\EmployeeAddressUpdateForm;
use Pyz\Zed\Employee\Communication\Form\EmployeeForm;
use Pyz\Zed\Employee\Communication\Form\EmployeeUpdateForm;
use Pyz\Zed\Employee\Communication\Table\EmployeeTable;
use Pyz\Zed\Employee\EmployeeDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Employee\Business\EmployeeFacadeInterface getFacade()
 * @method \Pyz\Zed\Employee\EmployeeConfig getConfig()
 */
class EmployeeCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return EmployeeTable
     */
    public function createEmployeeTable(): EmployeeTable
    {
        return new EmployeeTable($this->getQueryContainer());
    }

    /**
     * @return EmployeeFormDataProvider
     */
    public function createEmployeeFormDataProvider(): EmployeeFormDataProvider
    {
        return new EmployeeFormDataProvider($this->getQueryContainer());
    }

    /**
     * @param array $data
     * @param array $options
     * @return FormInterface
     */
    public function createEmployeeForm(EmployeeTransfer $data, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(EmployeeForm::class, $data, $options);
    }

    /**
     * @return EmployeeUpdateFormDataProvider
     */
    public function createEmployeeUpdateFormDataProvider(): EmployeeUpdateFormDataProvider
    {
        return new EmployeeUpdateFormDataProvider($this->getQueryContainer());
    }

    /**
     * @param array $data
     * @param array $options
     * @return FormInterface
     */
    public function createEmployeeUpdateForm(array $data = [], array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(EmployeeUpdateForm::class, $data, $options);
    }

    /**
     * @return EmployeeAddressesDataProvider
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createEmployeeAddressFormDataProvider(): EmployeeAddressesDataProvider
    {
        return new EmployeeAddressesDataProvider(
            $this->getQueryContainer(),
            $this->getProvidedDependency(EmployeeDependencyProvider::FACADE_COUNTRY),
            $this->getProvidedDependency(EmployeeDependencyProvider::STORE)
        );
    }

    /**
     * @param array $data
     * @param array $options
     * @return FormInterface
     */
    public function createEmployeeAddressesForm(EmployeeCreationFormTransfer $data, array $options): FormInterface
    {
        return $this->getFormFactory()->create(Addresses::class, $data, $options);
    }

    public function createEmployeeAddressesDataProvider()
    {
        return new EmployeeAddressesDataProvider(
            $this->getQueryContainer(),
            $this->getProvidedDependency(EmployeeDependencyProvider::FACADE_COUNTRY),
            $this->getProvidedDependency(EmployeeDependencyProvider::STORE)
        );
    }

    /**
     * @param array $data
     * @param array $options
     * @return FormInterface
     */
    public function createEmployeeAddressUpdateForm(array $data, array $options): FormInterface
    {
        return $this->getFormFactory()->create(EmployeeAddressUpdateForm::class, $data, $options);
    }

    /**
     * @return EmployeeAddressUpdateFormProvider
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createEmployeeAddressUpdateFormDataProvider()
    {
        return new EmployeeAddressUpdateFormProvider(
            $this->getQueryContainer(),
            $this->getProvidedDependency(EmployeeDependencyProvider::FACADE_COUNTRY),
            $this->getProvidedDependency(EmployeeDependencyProvider::STORE)
        );
    }

    /**
     * @return \Spryker\Zed\StateMachine\Business\StateMachineFacade
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getStateMachineFacade()
    {
        return $this->getProvidedDependency(EmployeeDependencyProvider::FACADE_STATE_MACHINE);
    }

    /**
     * @return mixed
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getUtilDateTimeService()
    {
        return $this->getProvidedDependency(EmployeeDependencyProvider::SERVICE_UTIL_DATE_TIME);
    }

    /**
     * @return mixed
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    private function getEmployeeTableActionExpanderPlugins()
    {
        return $this->getProvidedDependency(EmployeeDependencyProvider::PLUGINS_EMPLOYEE_TABLE_ACTION_EXPANDER);
    }
}
