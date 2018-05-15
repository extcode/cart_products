<?php

namespace Extcode\CartProducts\Domain\Model\Dto\Product;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class ProductDemand extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * Sku
     *
     * @var string
     */
    protected $sku;

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Categories
     *
     * @var array
     */
    protected $categories;

    /**
     * Order
     *
     * @var string
     */
    protected $order;

    /**
     * Action
     *
     * @var string
     */
    protected $action;

    /**
     * Class
     *
     * @var string
     */
    protected $class;

    /**
     * Returns sku
     *
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets sku
     *
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Returns title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title
     *
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * Returns order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets order
     *
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Returns action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Sets action
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
    /**
     * Returns class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets class
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Sets action and class
     *
     * @param string $action
     * @param string $controller
     */
    public function setActionAndClass($action, $controller)
    {
        $this->action = $action;
        $this->class = $controller;
    }
}
