.. include:: Includes.rst.txt

.. _start:

=============
Cart Products
=============

Cart Products - extend EXT:cart with products
=============================================

.. image:: Images/cart_products_logo.png
   :height: 100
   :width: 100


.. only:: html

   :Extension key:
      cart_products

   :Package name:
      extcode/cart-products

   :Version:
      |release|

   :Language:
      en

   :Author:
      Daniel Gohlke & Contributors

   :License:
      This document is published under the
      `Open Publication License <https://www.opencontent.org/openpub/>`__.

   :Rendered:
      |today|

-----

*Cart Products* needs to be used together with :t3ext:`cart`.

* EXT:cart itself is only the base for a webshop.
* EXT:cart_products provides products which can be created in the TYPO3 backend.

  * Those products fit many use cases for "usual products" (no books, no events).
  * The products can be displayed on the website with a list view and a detail view.
  * As said does it extend EXT:cart so those products can be purchased with the cart of EXT:cart.

-----

..  card-grid::
    :columns: 1
    :columns-md: 2
    :gap: 4
    :class: pb-4
    :card-height: 100

    ..  card:: :ref:`Introduction <introduction>`

        Introduction to the extension, general information.

    ..  card:: :ref:`For Administrators <administrator>`

        Install the extension and configure it correctly.

    ..  card:: :ref:`For Editors <editor>`

        Information about how to use this extension in the backend.

    ..  card:: :ref:`For Developers <developer>`

        Information about existing events to extend functionality.

    ..  card:: :ref:`Tutorials <tutorials>`

        Tutorials for a smooth setup of the extension.

    ..  card:: :ref:`Changelog <changelog>`

        Changes of this extension during updates.

.. toctree::
   :maxdepth: 1
   :titlesonly:
   :hidden:

   Introduction/Index
   Administrator/Index
   Editor/Index
   Developer/Index
   Tutorials/Index
   Changelog/Index
