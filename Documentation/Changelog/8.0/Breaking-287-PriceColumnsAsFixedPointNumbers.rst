.. include:: ../../Includes.rst.txt

=====================================================
Breaking: #287 - Price columns as fixed-point numbers
=====================================================

See `Pull Request 287 <https://github.com/extcode/cart_products/pull/287>`__

Description
===========

The price columns in the database changed from ``double(11,2)`` to
``decimal(17,5)`` to store prices without rounding errors and with more
than two decimal places:

*  ``tx_cartproducts_domain_model_product_product``: ``price``,
   ``price_measure``, ``base_price_measure``, ``service_attribute1``,
   ``service_attribute2``, ``service_attribute3``
*  ``tx_cartproducts_domain_model_product_specialprice``: ``price``
*  ``tx_cartproducts_domain_model_product_quantitydiscount``: ``price``
*  ``tx_cartproducts_domain_model_product_bevariant``: ``price``,
   ``price_measure``

Affected Installations
======================

All installations updating from cart_products 7.x.

Own queries or extensions which read these columns directly get the values
as numeric strings instead of floats from the database.

Migration
=========

Update the database schema, e.g. with the database analyzer in the install
tool or with ``vendor/bin/typo3 extension:setup``. The existing prices are
kept.

Cast the values of these columns in own queries, e.g. with ``(float)``.
