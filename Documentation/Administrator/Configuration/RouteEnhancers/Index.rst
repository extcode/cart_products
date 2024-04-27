.. include:: ../../../Includes.txt

===============
Route Enhancers
===============

To get speaking URLs it's necessary to add a Route Enhancer for the detail view.

Be aware that you need to adapt the `limitToPages` entry.

.. code-block:: yaml
   :caption: e.g. EXT:sitepackage/Configuration/TypoScript/setup.typoscript

    routeEnhancers:
      CartProducts:
        type: Extbase
        limitToPages:
          - 123
        extension: CartProducts
        plugin: Products
        routes:
          - routePath: '/{product-title}'
            _controller: 'Product::show'
            _arguments:
              product-title: product
        defaultController: 'Product::show'
        aspects:
          product-title:
            type: PersistedAliasMapper
            tableName: tx_cartproducts_domain_model_product_product
            routeFieldName: path_segment

.. NOTE::

   **Multi-site setup**

   The TCA configuration for `path_segment` sets `eval = uniqueInSite`.

   On a TYPO3 setup with multiple sites (= multiple roots) every site can have
   its own product with the same path segment. This means all sites can have
   an individual product with the path segment `t-shirt`.

   Due to this setting it is not possible to share products between multiple
   sites. To achieve this you need to set

   .. code-block:: php
      :caption: sitepackage/Configuration/TCA/Overrides/tx_cartproducts_domain_model_product_product.php

      $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['path_segment']['config']['eval'] = 'unique';
