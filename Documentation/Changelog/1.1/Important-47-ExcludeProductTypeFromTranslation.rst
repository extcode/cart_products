.. include:: ../../Includes.txt

======================================================
Important: #47 - Exclude Product Type from Translation
======================================================

See :issue:`47`

Description
===========

For each product you can select a type such as `simple` or `configurable`.
The product must of course have the same type in all languages.

Therefore, this change will remove the product type in the translations and
take the type of the original language.

.. IMPORTANT::
   Check your database for differences in translated products.
   If you are sure, the respective update query can also be used to adapt
   the data of the translations to the original language.

   .. code-block:: sql
      :caption: **Check and Update product_type in Products**

      SELECT orig.uid AS orig_uid, orig.title AS orig_title, orig.product_type AS orig_product_type, trans.uid AS trans_uid, trans.title AS trans_title, trans.product_type AS trans_product_type
      FROM `tx_cartproducts_domain_model_product_product` AS orig
      JOIN `tx_cartproducts_domain_model_product_product` AS trans ON orig.uid = trans.l10n_parent
      WHERE orig.product_type <> trans.product_type

      UPDATE `tx_cartproducts_domain_model_product_product` AS trans
      JOIN `tx_cartproducts_domain_model_product_product` AS orig ON orig.uid = trans.l10n_parent
      SET trans.product_type = orig.product_type
      WHERE orig.product_type <> trans.product_type

   Saving the products in the backend should update the field as well.

.. index:: TCA