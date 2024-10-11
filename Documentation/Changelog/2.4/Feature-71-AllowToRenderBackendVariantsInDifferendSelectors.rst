.. include:: ../../Includes.rst.txt

======================================================================
Feature: #71 - Allow to Render Backend Variants in Different Selectors
======================================================================

See `Issue 71 <https://github.com/extcode/cart_products/issues/71>`__

Description
===========

In many cases the selection of backend variants in the frontend is not so user-friendly, especially if a product has
more than one backend variant. In this case, every available combination is displayed as one entry in a selector.
This version extends the selector with additional data attributes that are used to resolve this one selector into
multiple selectors for each backend variant.

.. figure:: ../../Images/Changelog/2.4.0/BackendVariantsInSingleSelector.png
   :width: 800
   :alt: Backend Variants in Single Selector

   Before: each backend variant is an option in a single selector


.. figure:: ../../Images/Changelog/2.4.0/BackendVariantInDifferentSelectors.png
   :width: 800
   :alt: Backend Variants in Different Selectors

   After: backend variants were split into several selectors

The redesign is done via JavaScript, so that only a selector is displayed when JavaScript is deactivated.
The JavaScript then also ensures that only available options can be selected.

Integration
===========

Since this change in the view must first be adapted for the customer project, the necessary JavaScript is not
included by default. This will probably be done in the upcoming major version.

::
    page.includeJSFooter.tx_cartproducts = EXT:cart_products/Resources/Public/JavaScripts/cart.js

Attention
=========

The JavaScript is not yet finalized. There might be some changes in the coming minor versions. For this reason you
should either include a copy via your own site package or check the behaviour in the page after each update.

.. index:: Frontend
