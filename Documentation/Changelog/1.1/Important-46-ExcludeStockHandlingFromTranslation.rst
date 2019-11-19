.. include:: ../../Includes.txt

========================================================
Important: #46 - Exclude Stock Handling from Translation
========================================================

See :issue:`46`

Description
===========

For each product you can activate the stock management in the backend. Up to now, stock management was carried out
independently for each language.
The online shops implemented with the extension sell products with translated product titles and descriptions, but
not translated products.
Therefore there should be a collective stock for all translations of a product.

.. IMPORTANT::
   Check your database for differences in translated products.
   If any query shows a result, please take a closer look at the products
   or its backend variants and update them.
   If you are sure, the respective update query can also be used to adapt
   the data of the translations to the original language. For different
   stock levels in the products or their backend variants, this should be
   compared with the actual stock level.

   .. code-block:: sql
      :caption: **Check and Update handle_stock in Products**

      SELECT orig.uid AS orig_uid, orig.title AS orig_title, orig.handle_stock AS orig_handle_stock, trans.uid AS trans_uid, trans.title AS trans_title, trans.handle_stock AS trans_handle_stock
      FROM `tx_cartproducts_domain_model_product_product` AS orig
      JOIN `tx_cartproducts_domain_model_product_product` AS trans ON orig.uid = trans.l10n_parent
      WHERE orig.handle_stock <> trans.handle_stock

      UPDATE `tx_cartproducts_domain_model_product_product` AS trans
      JOIN `tx_cartproducts_domain_model_product_product` AS orig ON orig.uid = trans.l10n_parent
      SET trans.handle_stock = orig.handle_stock
      WHERE orig.handle_stock <> trans.handle_stock

   .. code-block:: sql
      :caption: **Check and Update handle_stock_in_variants in Products**

      SELECT orig.uid AS orig_uid, orig.title AS orig_title, orig.handle_stock_in_variants AS orig_handle_stock_in_variants, trans.uid AS trans_uid, trans.title AS trans_title, trans.handle_stock_in_variants AS trans_handle_stock_in_variants
      FROM `tx_cartproducts_domain_model_product_product` AS orig
      JOIN `tx_cartproducts_domain_model_product_product` AS trans ON orig.uid = trans.l10n_parent
      WHERE orig.handle_stock_in_variants <> trans.handle_stock_in_variants

      UPDATE `tx_cartproducts_domain_model_product_product` AS trans
      JOIN `tx_cartproducts_domain_model_product_product` AS orig ON orig.uid = trans.l10n_parent
      SET trans.handle_stock_in_variants = orig.handle_stock_in_variants
      WHERE orig.handle_stock_in_variants <> trans.handle_stock_in_variants

   .. code-block:: sql
      :caption: **Check and Update stock in Products**

      SELECT orig.uid AS orig_uid, orig.title AS orig_title, orig.stock AS orig_stock, trans.uid AS trans_uid, trans.title AS trans_title, trans.stock AS trans_stock
      FROM `tx_cartproducts_domain_model_product_product` AS orig
      JOIN `tx_cartproducts_domain_model_product_product` AS trans ON orig.uid = trans.l10n_parent
      WHERE orig.stock <> trans.stock

      UPDATE `tx_cartproducts_domain_model_product_product` AS trans
      JOIN `tx_cartproducts_domain_model_product_product` AS orig ON orig.uid = trans.l10n_parent
      SET trans.stock = orig.stock
      WHERE orig.stock <> trans.stock

   .. code-block:: sql
      :caption: **Check and Update stock in Backend Variants**

      SELECT orig.product, orig_product.title, orig.uid AS orig_uid, orig.stock AS orig_stock, trans.uid AS trans_uid, trans.stock AS trans_stock
      FROM `tx_cartproducts_domain_model_product_bevariant` AS orig
      JOIN `tx_cartproducts_domain_model_product_bevariant` AS trans ON orig.uid = trans.l10n_parent
      JOIN `tx_cartproducts_domain_model_product_product` AS orig_product ON orig.product = orig_product.uid
      WHERE orig.stock IS NOT NULL AND orig.stock <> trans.stock;

      UPDATE `tx_cartproducts_domain_model_product_bevariant` AS trans
      JOIN `tx_cartproducts_domain_model_product_bevariant` AS orig ON orig.uid = trans.l10n_parent
      SET trans.stock = orig.stock
      WHERE orig.stock IS NOT NULL AND orig.stock <> trans.stock

   Saving the products in the backend should update the field as well.

.. NOTE::

   If you require the old language-specific stock management, this version **must not** be installed.
   Please contact me in this case, so that an appropriate solution can be developed.

.. index:: TCA