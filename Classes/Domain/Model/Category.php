<?php

namespace Extcode\CartProducts\Domain\Model;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    /**
     * Images
     *
     * @var ObjectStorage<FileReference>
     */
    protected $images;

    /**
     * Cart Product List Pid
     *
     * @var int
     */
    protected $cartProductListPid;

    /**
     * Cart Product Single Pid
     *
     * @var int
     */
    protected $cartProductShowPid;

    /**
     * Returns Cart Product List Pid
     *
     * @return int
     */
    public function getCartProductListPid()
    {
        return $this->cartProductListPid;
    }

    /**
     * Returns Cart Product Single Pid
     *
     * @return int
     */
    public function getCartProductShowPid()
    {
        return $this->cartProductShowPid;
    }

    /**
     * Returns images
     *
     * @return ObjectStorage<FileReference>
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Returns the first image
     *
     * @return FileReference|null
     */
    public function getFirstImage()
    {
        $images = $this->getImages();
        foreach ($images as $image) {
            return $image;
        }
        return null;
    }
}
