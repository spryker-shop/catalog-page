<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerShop\Yves\CatalogPage;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class CatalogPageDependencyProvider extends AbstractBundleDependencyProvider
{

    const CLIENT_LOCALE = 'CLIENT_LOCALE';
    const CLIENT_SEARCH = 'CLIENT_SEARCH';
    const CLIENT_CATEGORY = 'CLIENT_CATEGORY';
    const PLUGIN_CATALOG_WIDGET_BUILDERS = 'PLUGIN_CATALOG_WIDGET_BUILDERS';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addSearchClient($container);
        $container = $this->addCategoryClient($container);
        $container = $this->addLocaleClient($container);
        $container = $this->addCatalogWidgetBuilderPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addSearchClient(Container $container)
    {
        $container[self::CLIENT_SEARCH] = function (Container $container) {
            return $container->getLocator()->search()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCategoryClient(Container $container)
    {
        $container[static::CLIENT_CATEGORY] = function (Container $container) {
            return $container->getLocator()->category()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addLocaleClient(Container $container)
    {
        $container[static::CLIENT_LOCALE] = function (Container $container) {
            return $container->getLocator()->locale()->client();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addCatalogWidgetBuilderPlugins(Container $container)
    {
        $container[static::PLUGIN_CATALOG_WIDGET_BUILDERS] = function (Container $container) {
            return $this->getCatalogWidgetBuilderPlugins();
        };

        return $container;
    }

    /**
     * @return \Spryker\Yves\Kernel\Dependency\Plugin\WidgetPluginInterface[]
     */
    protected function getCatalogWidgetBuilderPlugins()
    {
        return [];
    }

}
