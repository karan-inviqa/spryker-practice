<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Employee;

use Pyz\Zed\Employee\Dependancy\EmployeeToCountryBridge;
use Pyz\Zed\Employee\Dependancy\EmployeeToMailBridge;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class EmployeeDependencyProvider extends AbstractBundleDependencyProvider
{
    public const SERVICE_UTIL_DATE_TIME = 'SERVICE_UTIL_DATE_TIME';

    public const PLUGINS_EMPLOYEE_TABLE_ACTION_EXPANDER = 'PLUGINS_EMPLOYEE_TABLE_ACTION_EXPANDER';

    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const FACADE_COUNTRY = 'FACADE_COUNTRY';
    public const STORE = 'STORE';
    public const FACADE_STATE_MACHINE = 'FACADE_STATE_MACHINE';
    public const FACADE_MAIL = 'FACADE_MAIL';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = $this->addCountryFacade($container);
        $container = $this->addStore($container);

        $container[self::FACADE_STATE_MACHINE] = function (Container $container) {
            return $container->getLocator()->stateMachine()->facade();
        };

        return $container;
    }

    private function addCountryFacade(Container $container): Container
    {
        $container[static::FACADE_COUNTRY] = function (Container $container) {
            return new EmployeeToCountryBridge($container->getLocator()->country()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container[static::STORE] = function (Container $container) {
            return Store::getInstance();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addMailFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        //TODO Provide dependencies

        return $container;
    }

    protected function getEmployeeTableActionExpanderPlugins(Container $container): Container
    {
        return $container;
    }

    private function addMailFacade(Container $container):Container
    {
        $container[static::FACADE_MAIL] = function (Container $container) {
            return new EmployeeToMailBridge($container->getLocator()->mail()->facade());
        };

        return $container;
    }
}
