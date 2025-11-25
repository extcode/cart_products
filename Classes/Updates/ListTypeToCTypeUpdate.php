<?php

namespace Extcode\CartProducts\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

/*
 * This file is part of the package extcode/cart.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

#[UpgradeWizard('cartProducts_updateListTypeToCType')]
class ListTypeToCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'cartproducts_showproduct' => 'cartproducts_showproduct',
            'cartproducts_listproducts' => 'cartproducts_listproducts',
            'cartproducts_teaserproducts' => 'cartproducts_teaserproducts',
            'cartproducts_singleproduct' => 'cartproducts_singleproduct',
        ];
    }

    public function getTitle(): string
    {
        return 'Update cart_products list_type to CType.';
    }

    public function getDescription(): string
    {
        return 'Update all cart_products list_type plugin to CType.';
    }
}
