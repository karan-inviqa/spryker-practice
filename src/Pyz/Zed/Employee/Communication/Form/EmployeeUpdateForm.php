<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2018-12-24
 * Time: 13:02
 */

namespace Pyz\Zed\Employee\Communication\Form;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

/**
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainerInerface getQueryContainer()
 * @method \Pyz\Zed\Employee\Communication\CustomerCommunicationFactory getFactory()
 */
class EmployeeUpdateForm extends EmployeeForm
{
    /**
     * @return array
     */
    protected function createEmailConstraints()
    {
        $emailConstraints = [
            new NotBlank(),
            new Required(),
            new Email(),
        ];

        $employeeQuery = $this->getQueryContainer()->queryEmployees();

        return $emailConstraints;
    }
}