.. include:: ../../Includes.rst.txt

=============================================================
Feature: #314 - Shippable, cancelable and returnable products
=============================================================

See `Issue 314 <https://github.com/extcode/cart_products/issues/314>`__

Description
===========

Products have the new fields ``shippable``, ``cancelable`` and
``returnable`` (tab "General", enabled by default). When a product is
ordered, the EventListener ``cart-products--order--order-product-properties``
of the event ``\Extcode\Cart\Event\Order\BeforePersistOrderProductEvent`` of
extcode/cart stores them with the ordered product. Changing the product
afterwards does not change existing orders.

``shippable`` is only shown for physical products. Products of the types
"virtual" and "downloadable" are always stored as not shippable, extcode/cart
derives this from the virtual product flag of the product in the cart. A
physical product which is not shippable (e.g. picked up by the customer)
still counts for shipping costs based on the price of physical products.

Impact
======

The database schema has to be updated. Existing products are shippable,
cancelable and returnable.

.. index:: Backend, Database
