<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Karan\Page\AdminLoginPage;
use Karan\Page\EmployeePage;
use Karan\Page\Page;
use Karan\Helper\PageObjectHelperMethods;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /**
     * @var Page
     */
    protected $page;

    /**
     * @var EmployeePage
     */
    protected $employeePage;

    /**
     * @var AdminLoginPage
     */
    protected $adminLoginPage;

    /**
     * @var PageObjectHelperMethods
     */
    protected $pageObjectHelperMethods;


    protected $employeeCount;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     * @param Page $page
     * @param EmployeePage $employeePage
     * @param AdminLoginPage $adminLoginPage
     */
    public function __construct(Page $page, EmployeePage $employeePage, AdminLoginPage $adminLoginPage)
    {
        $this->employeePage = $employeePage;
        $this->page = $page;
        $this->adminLoginPage = $adminLoginPage;

    }

    /**
     * @Given there are :employee employees added
     */
    public function thereAreEmployeesAdded($employee)
    {
        $this->setEmployeeCount($employee);
    }

    /**
     * @When I visit employee page
     */
    public function iVisitEmployeePage()
    {
        $this->adminLoginPage->openPage();
        $this->adminLoginPage->getLoggedInWithAdminUser();
        $this->employeePage->openPage();
    }

    /**
     * @Then I should get :arg1 message
     */
    public function iShouldGetMessage($arg1)
    {
        $this->page->hasContent($arg1);
    }

    /**
     * @Then I should get list of :arg1 employees
     */
    public function iShouldGetListOfEmployees($arg1)
    {
       $this->employeePage->isOpen();
       /*$expectedEmail = $this->page->find('css','.column-email')->getText();
       echo  $expectedEmail;*/
    }

    /**
     * @Given /^Add a new employee$/
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function addANewEmployee()
    {
        $this->employeePage->addNewEmployee();
    }


    protected function setEmployeeCount($count)
    {
        $this->employeeCount = $count;
    }

    protected function getEmployeeCount()
    {
        return $this->employeeCount;
    }
}
