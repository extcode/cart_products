.. include:: ../../Includes.rst.txt

====================================================
Breaking: #204 - Migrate switchableControllerActions
====================================================

See :Issue 204 <https://github.com/extcode/cart_products/issues/204>`

Description
===========

Switchable Controller Actions are removed in TYPO3 v12. The existing plugin
"Cart: Products" was split into to plugins. A upgrade wizard cares about
the updating.
Important: Due to the changed pluginName you will need to adapt your
RouteEnhancers in your SiteConfiguration.

Affected Installations
======================

All installations which are not set up with version 5 of EXT:cart_products
(before TYPO3 v12).

Migration
=========

1. Run the UpdateWizard "Migrates plugins of existing cart_produts plugins
using switchableControllerActions".
2. Adapt the value of `plugin` from `Products` to `ShowProduct` in your site
configuration (`config/sites/<your-site>/config.yaml`):

**BEFORE:**

.. code-block:: yaml
   :caption: config/sites/<your-site>/config.yaml

    routeEnhancers:
      CartProducts:
        type: Extbase
        limitToPages:
          - 123
        extension: CartProducts
        plugin: Products
        routes:
        ...

**AFTER:**

.. code-block:: yaml
   :caption: config/sites/<your-site>/config.yaml

    routeEnhancers:
      CartProducts:
        type: Extbase
        limitToPages:
          - 123
        extension: CartProducts
        plugin: ShowProduct
        routes:
        ...

.. index:: Database, Routing
