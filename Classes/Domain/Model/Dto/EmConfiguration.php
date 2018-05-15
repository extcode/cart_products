<?php
namespace Extcode\CartProducts\Domain\Model\Dto;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class EmConfiguration
{

    /**
     * Fill the properties properly
     *
     * @param array $configuration em configuration
     */
    public function __construct(array $configuration)
    {
        foreach ($configuration as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @var string;
     */
    protected $categoryRestriction = '';

    /**
     * @return string
     */
    public function getCategoryRestriction()
    {
        return $this->categoryRestriction;
    }
}
