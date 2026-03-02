<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CatalogPage\Plugin\StorageRouter;

use Spryker\Shared\CategoryStorage\CategoryStorageConstants;
use Spryker\Yves\Kernel\AbstractPlugin;
use SprykerShop\Yves\StorageRouterExtension\Dependency\Plugin\ResourceCreatorPluginInterface;

/**
 * @method \SprykerShop\Yves\CatalogPage\CatalogPageFactory getFactory()
 */
class CatalogPageResourceCreatorPlugin extends AbstractPlugin implements ResourceCreatorPluginInterface
{
    /**
     * @var string
     */
    public const ATTRIBUTE_CATEGORY_NODE = 'categoryNode';

    public function getType(): string
    {
        return CategoryStorageConstants::CATEGORY_NODE_RESOURCE_NAME;
    }

    public function getModuleName(): string
    {
        return 'CatalogPage';
    }

    public function getControllerName(): string
    {
        return 'Catalog';
    }

    public function getActionName(): string
    {
        return 'index';
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function mergeResourceData(array $data): array
    {
        return [
            static::ATTRIBUTE_CATEGORY_NODE => $data,
        ];
    }
}
