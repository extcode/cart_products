<?php

namespace Extcode\CartProducts\Domain\Model;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    /**
     * Images
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Returns the first image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
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
