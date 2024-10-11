.. include:: ../../Includes.txt

======================================================
Breaking: #138 - Listen to ProcessOrderCheckStockEvent
======================================================

See :Issue 138 <https://github.com/extcode/cart_products/issues/138>`

Description
===========

`EXT:cart` v9 has an extended :php:`Extcode\Cart\Domain\Model\Cart\Cart\ProcessOrderCheckStockEvent`.
This allows product extensions as `EXT:cart_product` to set a flag if any
product of an order is not available in sufficient amount (means: less articles
in stock than what a customer wants to order).

The new Event Listener :php:`Extcode\CartProducts\EventListener\Order\Stock\CheckStock`
checks whether the stock of any article is lower than what a customer wants to
order. This situation can happen when customer B ordered the same product
after customer A put the article into the cart. Customer A will get in this case
a message that the article is no longer available in the desired amount and the
order can not be finished until customer A adapts the amount.

This prevents a TYPO3 Exception "[..] Out of range value for column 'stock'
[...]".

Impact
======

Negative effects are not expected. This feature works out of the box when
stock handling is activated. As long as flash messages are shown in the order
form it's not necessary to adapt anything.

It is of course possible to override the displayed message which has the key
`tx_cart.error.stock_handling.order` (in EXT:cart).

.. index:: Backend
