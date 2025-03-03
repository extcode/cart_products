.. include:: ../../Includes.rst.txt

=====================================================================
Feature: #259 - Replace SimplePagination with SlidingWindowPagination
=====================================================================

See `Issue 259 <https://github.com/extcode/cart_products/issues/259>`__

Description
===========

If you have a long list of products, you would like to display them in a pagination
with a defined number of products per page. This is already possible with the
TypoScript configuration `itemsPerPage`. With a large number of products, the
display of all page links may not work well, especially when it comes to the
display on mobile devices.
The TYPO3 core offers the SlidingWindowPagination since TYPO3 v12.
This is compatible with the previously used SimplePagination if you pass the
value 0 for the number of links.

Integration
===========

Set the new TypoScript configuration variable `plugin.tx_cartproducts.maximumNumberOfLinks` to a value greater than 0.
If you use an own template file for `Resources/Private/Partials/Utility/Paginator.html` you have to adapt the changes
to your file.

.. index:: Frontend
