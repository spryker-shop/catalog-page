<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CatalogPage;

use Generated\Shared\Transfer\ShopContextTransfer;
use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\Kernel\Application;
use SprykerShop\Yves\CatalogPage\ActiveSearchFilter\UrlGenerator;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToCatalogClientInterface;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToCategoryStorageClientInterface;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToLocaleClientInterface;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToProductCategoryFilterClientInterface;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToProductCategoryFilterStorageClientInterface;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToSearchClientInterface;
use SprykerShop\Yves\CatalogPage\Dependency\Client\CatalogPageToStoreClientInterface;
use SprykerShop\Yves\CatalogPage\Dependency\Service\CatalogPageToUtilNumberServiceInterface;
use SprykerShop\Yves\CatalogPage\FacetFilter\FacetFilter;
use SprykerShop\Yves\CatalogPage\FacetFilter\FacetFilterInterface;
use SprykerShop\Yves\CatalogPage\Resolver\ShopContextResolver;
use SprykerShop\Yves\CatalogPage\Resolver\ShopContextResolverInterface;
use SprykerShop\Yves\CatalogPage\Twig\CatalogPageTwigExtension;

/**
 * @method \SprykerShop\Yves\CatalogPage\CatalogPageConfig getConfig()
 */
class CatalogPageFactory extends AbstractFactory
{
    /**
     * @var string
     */
    protected const SERVICE_SHOP_CONTEXT = 'shop_context';

    /**
     * @return \SprykerShop\Yves\CatalogPage\ActiveSearchFilter\UrlGeneratorInterface
     */
    public function createActiveSearchFilterUrlGenerator()
    {
        return new UrlGenerator($this->getSearchClient(), $this->getConfig());
    }

    public function createFacetFilter(): FacetFilterInterface
    {
        return new FacetFilter(
            $this->getConfig(),
        );
    }

    public function getCategoryStorageClient(): CatalogPageToCategoryStorageClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_CATEGORY_STORAGE);
    }

    public function getLocaleClient(): CatalogPageToLocaleClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_LOCALE);
    }

    public function getSearchClient(): CatalogPageToSearchClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_SEARCH);
    }

    /**
     * @return \Spryker\Shared\Twig\TwigExtension
     */
    public function createProductAbstractReviewTwigExtension()
    {
        return new CatalogPageTwigExtension($this->createActiveSearchFilterUrlGenerator());
    }

    public function getCatalogClient(): CatalogPageToCatalogClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_CATALOG);
    }

    /**
     * @return array<string>
     */
    public function getCatalogPageWidgetPlugins(): array
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::PLUGIN_CATALOG_PAGE_WIDGETS);
    }

    public function getProductCategoryFilterClient(): CatalogPageToProductCategoryFilterClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_PRODUCT_CATEGORY_FILTER);
    }

    public function getProductCategoryFilterStorageClient(): CatalogPageToProductCategoryFilterStorageClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_PRODUCT_CATEGORY_FILTER_STORAGE);
    }

    public function getStoreClient(): CatalogPageToStoreClientInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::CLIENT_STORE);
    }

    public function getModuleConfig(): CatalogPageConfig
    {
        return $this->getConfig();
    }

    public function getShopContext(): ShopContextTransfer
    {
        return $this->createShopContextResolver()->resolve();
    }

    public function createShopContextResolver(): ShopContextResolverInterface
    {
        return new ShopContextResolver($this->getContainer());
    }

    /**
     * @deprecated Use {@link \Spryker\Yves\Kernel\AbstractFactory::getContainer()} instead.
     *
     * @return \Spryker\Yves\Kernel\Application
     */
    public function getApplication(): Application
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::PLUGIN_APPLICATION);
    }

    public function getUtilNumberService(): CatalogPageToUtilNumberServiceInterface
    {
        return $this->getProvidedDependency(CatalogPageDependencyProvider::SERVICE_UTIL_NUMBER);
    }
}
