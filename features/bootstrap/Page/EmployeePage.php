<?php

namespace Karan\Page;

/**
 * Class EmployeePage
 * @package Karan\Page
 */
class EmployeePage extends Page
{
    const EMAIL_DOMAIN = '@inviqa.com';
    /**
     * @var string
     */
    protected $path = 'employee';

    /**
     * Employee table elements
     * @var array
     */
    protected $tableElements = [
        'no-employee-message' => ['css' => '.dataTables_empty'],
        'employee-tabale' => ['css' => '.dataTable tbody']
    ];

    /**
     * Employee form elements
     * @var array
     */
    protected $employeeElements = [
        'email' => 'employee_email',
        'salutation' => "employee_salutation",
        'firstname' => 'employee_firstName',
        'lastname' => 'employee_lastName',
        'currentAddress' => 'employee_currentAddress',
        'permanentAdress' => 'employee_permanentAddress',
        'gender' => 'employee_gender',
        'dob' => 'employee_dateOfBirth',
        'phone' => 'employee_phone'
    ];

    /**
     * Employee address form elements
     * @var array
     */
    protected $employeeAddressElements = [
        'salutation' => "addresses_addresses___name___salutation",
        'firstname' => 'addresses_addresses___name___firstName',
        'lastname' => 'addresses_addresses___name___lastName',
        'street1' => 'addresses_addresses___name___street1',
        'street2' => 'addresses_addresses___name___street2',
        'city' => 'addresses_addresses___name___city',
        'country' => 'addresses_addresses___name___fkCountry',
        'postcode' => 'addresses_addresses___name___postcode',
        'phone' => 'addresses_addresses___name___phone'
    ];

    /**
     * Employee data
     * @var array
     */
    protected $employeeData = [
        'email' => '12345@inviqa.com',
        'salutation' => "Mr",
        'firstname' => 'karan',
        'lastname' => 'popat',
        'currentAddress' => 'This is my current address.',
        'permanentAdress' => 'This is my permanent address',
        'gender' => 'Male',
        'dob' => '1992-03-13',
        'phone' => '9033336737'
    ];

    /**
     * Employee address data
     * @var array
     */
    protected $employeeAddressData = [
        'salutation' => "Mr",
        'firstname' => 'karan',
        'lastname' => 'popat',
        'street1' => 'Street 1',
        'street2' => 'Street 2',
        'city' => 'City',
        'country' => '60',
        'postcode' => '3800015',
        'phone' => '9033336737'
    ];

    protected $formButtons = [
        'add_new_employee' => '.btn.btn-sm.btn-outline.safe-submit.btn-create',
        'save_employee' => '.btn.btn-primary.safe-submit',
        'add_address' => 'add-address'
    ];

    /**
     * Add new employee
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function addNewEmployee(): void
    {
        $this->openNewEmployeeForm($this->formButtons);

        $this->fillEmployeeDataForm(
            $this->employeeElements,
            $this->employeeData);

        $this->fillEmployeeAddressForm(
            $this->employeeAddressElements,
            $this->employeeAddressData,
            1);

        $this->submitEmployeeForm($this->formButtons);
    }

    /**
     * @param array $formButtons
     */
    private function openNewEmployeeForm(array $formButtons): void
    {
        $this->clickElementByCssClass($formButtons['add_new_employee']);
    }

    /**
     * @param $locater
     */
    private function clickElementByCssClass($locater): void
    {
        $this->find('css', $locater)->click();
        $this->waitForPageLoad();
    }

    /**
     * fill employee data form
     *
     * @param array $employeeElements
     * @param array $employeeData
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    private function fillEmployeeDataForm(array $employeeElements, array $employeeData): void
    {
        $employeeData['email'] = $this->generateEmailId(8);
        foreach ($employeeData as $employeeField => $employeeValue) {
            $this->fillField($employeeElements[$employeeField], $employeeValue);
        }
    }

    /**
     * fill employee address form
     *
     * @param array $employeeAddressElements
     * @param array $employeeAddressData
     * @param int $count
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    private function fillEmployeeAddressForm(array $employeeAddressElements, array $employeeAddressData, int $count = 1): void
    {
        $_count = 0;
        foreach ($employeeAddressData as $employeeAddressField => $employeeAddressFieldValue) {
            $_employeeAddressField = str_replace('__name__', $_count, $employeeAddressElements[$employeeAddressField]);
            $this->fillField($_employeeAddressField, $employeeAddressFieldValue);
        }
    }

    /**
     * submit employee form
     *
     * @param array $formButtons
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    private function submitEmployeeForm(array $formButtons): void
    {
        $this->clickElementByCssClass($formButtons['save_employee']);
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateEmailId(int $length = 6):string
    {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str.static::EMAIL_DOMAIN;
    }

}