.. include:: ../../../Includes.rst.txt

======
Prices
======

Minimum numbers of product items per order
==========================================

Defines the minimal number that needs to be in the cart to buy this product.

It is possible to add less articles into the cart but a warning message will
be displayed in the cart itself and it's not possible to finish the order.

.. NOTE::
   A change of this field will not be applied to existing cart sessions. To make
   it work existing cart session need be deleted.

Maximum numbers of product items per order
==========================================

Defines the maximal number that are allowed to be in the cart to buy this
product.

It is possible to add more articles into the cart but a warning message will
be displayed in the cart itself and it's not possible to finish the order.

.. NOTE::
   A change of this field will not be applied to existing cart sessions. To make
   it work existing cart session need be deleted.

Is Net Price
============

Decides whether the price entered in the backend is net or gross.

Price
=====

The price of the product. When using BE variants this price will be part of the
price calculation or might be ignored at all.

Tax class
=========

The tax class of the product. Tax classes are defined in EXT:cart.

Special Prices
==============

Allows to add prices for logged-in FE users. This can also be limited to FE user
with a certain user group which allows to offer different prices depending on
the user group.

If multiple special prices exist the best special price will be applied.

When using BE variants this field will be ignored as the special price needs to
be defined for every single BE variant.

Quantity discount
=================

Allows to offer better prices when the amount of products in the cart exceeds
a certain limit.

.. NOTE::
   This does at the moment not work for products with BE variants.
