.. include:: ../../Includes.txt

================================================
Breaking: #186 - Changed key for image reference
================================================

See :Issue 186 <https://github.com/extcode/cart_products/issues/186>`

Description
===========

With the version for TYPO3 v12 the references uses the key 'images' in
column `fieldname` of table `sys_file_reference`. Before the key was 'image'
(singular). Due to this the images are no longer shown, neither in the backend
nor in the frontend.

Affected Installations
======================

All installations which are not set up with version 5 of EXT:cart_products
(before TYPO3 v12).

Migration
=========

Run the UpdateWizard "Updates image references for EXT:cart_products".

.. index:: Database
