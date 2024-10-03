.. include:: ../../Includes.rst.txt

.. _add-products-within-list-view:

=============================================
Add products to the cart within the list view
=============================================

In some cases you don't need a detail page for the products and want to allow
adding products to the shopping cart within the list view.

Integration
===========

Create in your extension (e.g. your `EXT:sitepackage`) an overwrite of
`EXT:cart_products/Resources/Private/Partials/Products/List/Grid.html` or
`EXT:cart_products/Resources/Private/Partials/Products/List/Table.html`.

Then you add the snippet as shown below:

.. code-block:: html
   :caption: EXT:sitepackage/Resources/Private/Cart/Partials/Products/List/Grid.html

    ...
    <f:cObject typoscriptObjectPath="lib.cartProduct.showForm" data="{productUid: '{product.uid}'}"/>
    ...
