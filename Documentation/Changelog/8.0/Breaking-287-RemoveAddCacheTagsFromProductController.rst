.. include:: ../../Includes.rst.txt

=============================================================
Breaking: #287 - Remove addCacheTags() from ProductController
=============================================================

See `Pull Request 287 <https://github.com/extcode/cart_products/pull/287>`__

Description
===========

The protected method
``\Extcode\CartProducts\Controller\ProductController::addCacheTags()`` was
removed, because it used ``$GLOBALS['TSFE']``, which no longer exists in
TYPO3 v14.

Affected Installations
======================

All installations with an own controller extending the ``ProductController``
which calls or overrides ``addCacheTags()``.

Migration
=========

Add cache tags with the cache data collector of the request:

.. code-block:: php

   $this->request->getAttribute('frontend.cache.collector')->addCacheTags(
       new \TYPO3\CMS\Core\Cache\CacheTag('tx_cartproducts_product_' . $product->getUid())
   );
