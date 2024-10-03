.. include:: ../../Includes.rst.txt

=======
General
=======

Language
========

Display the language of the product which is currently edited.

Type
====

Products can have 4 different types:

================== =============================================================
Type               Description
================== =============================================================
simple             The default value, no special meaning.
configurable       Allows to create BE variants for the product.
virtual            Shipping costs in EXT:cart can be configured to not be calculated for virtual products, e.g. with `plugin.tx_cart.shipping.countries.de.options.1.extra = by_number_of_physical_products`. Individual handling for other use cases can be implemented by listening to Events during the order process.
downloadable       Same behaviour as above described in 'virtual'. There is no implemented process for this type as the process can be highly individual: Show a download link on the 'Thank you' page or in an email. Another process could be to provide a link for logged-in FE users in their user account. Another implementation could need a watersign process which individualizes a PDF. Such processes can be implemented by listening to Events during the order process.
================== =============================================================

SKU (Stock Keeping Unit)
========================

The product identifier, when using Variants the resulting identifier will be
this base with trailed SKUs of the chosen variants.

Title
=====

Title of the product

URL segment
===========

The url segment which is used in the URL when `RouteEnhancers <https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ApiOverview/Routing/>`_ are defined.
