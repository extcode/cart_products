.. include:: ../../Includes.rst.txt

8.0 Changes
===========

**Table of contents**

.. contents::
   :local:
   :depth: 1

8.0.2
-----

Bugfixes
~~~~~~~~

*  Tag the page cache with the shown products again (`#313 <https://github.com/extcode/cart_products/pull/313>`__)
*  Flush the cache after handling the stock of products (`#313 <https://github.com/extcode/cart_products/pull/313>`__)

Tasks
~~~~~

*  Check spelling with typos (`#310 <https://github.com/extcode/cart_products/pull/310>`__)
*  List the changes of each release in the changelog

8.0.1
-----

Tasks
~~~~~

*  Run tests and linters via Build/Scripts (`#295 <https://github.com/extcode/cart_products/pull/295>`__, `#300 <https://github.com/extcode/cart_products/pull/300>`__)

8.0.0
-----

Compatibility
~~~~~~~~~~~~~

*  TYPO3 ^14.3 (was ^13.4)
*  extcode/cart ^12.0 (was ^11.0)

Breaking
~~~~~~~~

*  :doc:`#287 - Price columns as fixed-point numbers <Breaking-287-PriceColumnsAsFixedPointNumbers>`
*  :doc:`#287 - Remove addCacheTags() from ProductController <Breaking-287-RemoveAddCacheTagsFromProductController>`

Bugfixes
~~~~~~~~

*  Correct stock handling for backend variants (`#281 <https://github.com/extcode/cart_products/pull/281>`__)
*  Add missing value for area divider item (`#286 <https://github.com/extcode/cart_products/pull/286>`__)

.. toctree::
   :hidden:
   :glob:

   *-*
