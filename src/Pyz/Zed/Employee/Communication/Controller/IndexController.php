<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\Employee\Business\EmployeeFacade getFacade()
 * @method \Pyz\Zed\Employee\Communication\EmployeeCommunicationFactory getFactory()
 * @method \Pyz\Zed\Employee\Persistence\EmployeeQueryContainer getQueryContainer()
 */
class IndexController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $table = $this->getFactory()
            ->createEmployeeTable();

        return $this->viewResponse([
            'employeeTable' => $table->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $table = $this->getFactory()
            ->createEmployeeTable();

        return $this->jsonResponse($table->fetchData());
    }
}
