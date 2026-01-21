<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\CatalogPage\FacetFilter;

use Generated\Shared\Transfer\FacetSearchResultTransfer;
use Generated\Shared\Transfer\FacetSearchResultValueTransfer;
use Generated\Shared\Transfer\RangeSearchResultTransfer;
use SprykerShop\Yves\CatalogPage\CatalogPageConfig;

class FacetFilter implements FacetFilterInterface
{
    /**
     * @var \SprykerShop\Yves\CatalogPage\CatalogPageConfig
     */
    protected $catalogPageConfig;

    /**
     * @param \SprykerShop\Yves\CatalogPage\CatalogPageConfig $catalogPageConfig
     */
    public function __construct(CatalogPageConfig $catalogPageConfig)
    {
        $this->catalogPageConfig = $catalogPageConfig;
    }

    /**
     * @param array $facets
     *
     * @return array
     */
    public function getFilteredFacets(array $facets): array
    {
        $filteredFacets = [];

        foreach ($facets as $facet) {
            if ($facet instanceof RangeSearchResultTransfer) {
                $filteredFacets = $this->filterRangeSearchResults($facet, $filteredFacets);

                continue;
            }

            if (!$facet instanceof FacetSearchResultTransfer) {
                continue;
            }

            if ($facet->getActiveValue() && !$this->isActiveValueInValues($facet)) {
                $facet = $this->addActiveValueToValues($facet);
            }

            if ($facet->getValues()->count() === 0) {
                continue;
            }

            $filteredFacets[] = $facet;
        }

        return $filteredFacets;
    }

    /**
     * @param \Generated\Shared\Transfer\RangeSearchResultTransfer $rangeSearchResultTransfer
     * @param array<\Generated\Shared\Transfer\FacetSearchResultTransfer|\Generated\Shared\Transfer\RangeSearchResultTransfer> $filteredFacets
     *
     * @return array<\Generated\Shared\Transfer\FacetSearchResultTransfer|\Generated\Shared\Transfer\RangeSearchResultTransfer>
     */
    protected function filterRangeSearchResults(RangeSearchResultTransfer $rangeSearchResultTransfer, array $filteredFacets): array
    {
        if ($this->isRangeFilterVisible($rangeSearchResultTransfer)) {
            $filteredFacets[] = $rangeSearchResultTransfer;
        }

        return $filteredFacets;
    }

    /**
     * @param \Generated\Shared\Transfer\RangeSearchResultTransfer $rangeSearchResultTransfer
     *
     * @return bool
     */
    protected function isRangeFilterVisible(RangeSearchResultTransfer $rangeSearchResultTransfer): bool
    {
        if ($this->catalogPageConfig->isVisibleEmptyRangeFilters()) {
            return true;
        }

        return $rangeSearchResultTransfer->getActiveMaxOrFail() || $rangeSearchResultTransfer->getActiveMinOrFail();
    }

    /**
     * @param \Generated\Shared\Transfer\FacetSearchResultTransfer $facetSearchResultTransfer
     *
     * @return bool
     */
    protected function isActiveValueInValues(FacetSearchResultTransfer $facetSearchResultTransfer): bool
    {
        $activeValues = is_string($facetSearchResultTransfer->getActiveValue()) ? [$facetSearchResultTransfer->getActiveValue()] : (array)$facetSearchResultTransfer->getActiveValue();

        return !array_diff($activeValues, $this->getFacetValues($facetSearchResultTransfer));
    }

    /**
     * @param \Generated\Shared\Transfer\FacetSearchResultTransfer $facetSearchResultTransfer
     *
     * @return \Generated\Shared\Transfer\FacetSearchResultTransfer
     */
    protected function addActiveValueToValues(FacetSearchResultTransfer $facetSearchResultTransfer): FacetSearchResultTransfer
    {
        $activeValues = is_string($facetSearchResultTransfer->getActiveValue()) ? [$facetSearchResultTransfer->getActiveValue()] : (array)$facetSearchResultTransfer->getActiveValue();
        $values = $this->getFacetValues($facetSearchResultTransfer);

        foreach ($activeValues as $activeValue) {
            if (in_array($activeValue, $values, true)) {
                continue;
            }

            $facetSearchResultTransfer->addValue(
                (new FacetSearchResultValueTransfer())
                    ->setValue($activeValue)
                    ->setDocCount(0),
            );
        }

        return $facetSearchResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\FacetSearchResultTransfer $facetSearchResultTransfer
     *
     * @return list<string>
     */
    protected function getFacetValues(FacetSearchResultTransfer $facetSearchResultTransfer): array
    {
        $values = [];

        foreach ($facetSearchResultTransfer->getValues() as $facetSearchResultValueTransfer) {
            $values[] = $facetSearchResultValueTransfer->getValue();
        }

        return $values;
    }
}
