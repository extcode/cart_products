.. include:: ../../Includes.rst.txt

======
Events
======

The extcode/cart_products extension uses events in some places, especially to
integrate custom requirements in the ordering process.

You can register your own EventListener for the following
Events:

.. confval:: \Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent

   Triggered when the customer adds a product to the cart. It is already
   heavily used by the extension itself. The `ProductProduct` is the object
   of EXT:cart_products while `CartProduct` is an object of EXT:cart. The
   already registered EventListener care about transferring the needed
   information from `ProductProduct` to `CartProduct`. A custom EventListener
   can e.g. add further information.

