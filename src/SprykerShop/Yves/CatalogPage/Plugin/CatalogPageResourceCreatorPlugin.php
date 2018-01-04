<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CatalogPage\Plugin;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Zed\Category\CategoryConfig;
use SprykerShop\Yves\ShopRouter\Dependency\Plugin\ResourceCreatorPluginInterface;

/**
 * @method \SprykerShop\Yves\CatalogPage\CatalogPageFactory getFactory()
 */
class CatalogPageResourceCreatorPlugin extends AbstractPlugin implements ResourceCreatorPluginInterface
{
    const ATTRIBUTE_CATEGORY_NODE = 'categoryNode';

    /**
     * @return string
     */
    public function getType()
    {
        return CategoryConfig::RESOURCE_TYPE_CATEGORY_NODE;
    }

    /**
     * @return string
     */
    public function getModuleName()
    {
        return 'CatalogPage';
    }

    /**
     * @return string
     */
    public function getControllerName()
    {
        return 'Catalog';
    }

    /**
     * @return string
     */
    public function getActionName()
    {
        return 'index';
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function mergeResourceData(array $data)
    {
        return [
            static::ATTRIBUTE_CATEGORY_NODE => $data,
        ];
    }
}
