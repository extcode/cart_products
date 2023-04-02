<?php

namespace Extcode\CartProducts\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    protected int $cartProductListPid;

    protected int $cartProductShowPid;

    /**
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $images;

    public function getCartProductListPid(): ?int
    {
        return $this->cartProductListPid;
    }

    public function getCartProductShowPid(): ?int
    {
        return $this->cartProductShowPid;
    }

    /**
     * @return ObjectStorage<FileReference>
     */
    public function getImages(): ObjectStorage
    {
        return $this->images;
    }

    public function getFirstImage(): ?FileReference
    {
        $images = $this->getImages();

        foreach ($images as $image) {
            return $image;
        }

        return null;
    }
}
