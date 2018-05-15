<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
abstract class AbstractProduct extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * SKU
     *
     * @var string
     * @validate NotEmpty
     */
    protected $sku = '';

    /**
     * Title
     *
     * @var string
     * @validate NotEmpty
     */
    protected $title = '';

    /**
     * Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * Returns SKU
     *
     * @return string $sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets SKU
     *
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Returns Title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets Title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns Description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
