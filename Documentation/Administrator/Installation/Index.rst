.. include:: ../../Includes.txt

============
Installation
============

The installation consists of adding the extension and including the TypoScript.
To get a working cart you need to setup EXT:cart before.

Install the extension
=====================

Depending on your needs you have three options to install the extension.

Installation using composer
---------------------------

The recommended way to install the extension is by using `Composer <https://getcomposer.org/>`_.

In your composer-based TYPO3 project root, just do

.. code-block:: bash

   composer require extcode/cart-products

Installation from TYPO3 Extension Repository (TER)
--------------------------------------------------

Download and install the extension with the extension manager module.

Latest version from git
-----------------------
You can get the latest version from git by using the git command:

.. code-block:: bash

   git clone git@github.com:extcode/cart_products.git


Include TypoScript
==================

The extension ships some TypoScript code which needs to be included.
There are two valid ways to do this:


Include TypoScript via TYPO3 backend
------------------------------------

. Switch to the root page of your site.

#. Switch to the :guilabel:`Template module` and select *Info/Modify*.

#. Press the link :guilabel:`Edit the whole template record` and switch to the tab
   *Includes*.

#. Select :guilabel:`Shopping Cart - Cart Products` at the field *Include static (from
   extensions):*


Include TypoScript via SitePackage
----------------------------------
This way is preferred because the configuration is under version control.

#. Add :typoscript:`@import 'EXT:cart_products/Configuration/TypoScript/setup.typoscript'`
   to your e.g. `sitepackage/Configuration/TypoScript/setup.typoscript`

#. Add :typoscript:`@import 'EXT:cart_products/Configuration/TypoScript/constants.typoscript'`
   to your e.g. `sitepackage/Configuration/TypoScript/constants.typoscript`
