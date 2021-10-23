.. include:: ../../Includes.txt

============================================
Breaking: #99 - Add Pagination to Controller
============================================

See :issue:`99`

Description
===========

Because in TYPO3 v11 no pagination in the frontend is possible without an own
ViewHelper or an extension, the list action in the ProductController was
extended by the pagination. Via TypoScript it can be defined how many products
should be displayed per page.

Integration
===========

An example was implemented in the list action template.

.. index:: Template, Frontend
