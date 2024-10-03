.. include:: ../../Includes.rst.txt

===================================================
Breaking: #99 - Move Fluid Pagination to Controller
===================================================

See `Issue 99 <https://github.com/extcode/cart_products/issues/99>`__

Description
===========

In TYPO3 v11 <f:paginate> has been removed and is implemented via the
controller.

Affected Installations
======================

All installations are affected by this change.

Migration
=========

If the templates for the lists of products in the frontend has been
overwritten, then these templates must also be adapted. If pagination is not
desired, a custom template must be used for the product list.

.. index:: Template, Frontend
