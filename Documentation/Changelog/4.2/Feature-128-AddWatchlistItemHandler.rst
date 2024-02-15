.. include:: ../../Includes.txt

=======================================================================
Feature: #128 - Adds a WatchlistItemHandler for werkraummedia/watchlist
=======================================================================

See :issue:`128`

Description
===========

The TYPO3 extension werkraummedia/watchlist offers a generic approach for watch lists.
This version implements a WatchlistItemHandler to add or remove products from the watchlist.
The watchlist is only stored in the session with the current version of the package.
If the session is deleted or expires, the watchlist is then empty.

Integration
===========

A new Fluid partial `Resources/Private/Partials/Product/WatchlistButtons.html` can be included
in your templates.

The partial can also be overwritten, but the basic structure, the data attribute and the classes should be retained, otherwise the JavaScript from the watchlist package would have to be adapted.
The current version composes the key for the entry in the watchlist from the `uid` of the product, the `uid` of the detail page. In this way, the watchlist can also link to the product's detail page.

To achieve this, the watchlist template must be supplemented. This could look something like this:

.. code-block:: php
   :caption: EXT:watchlist/Resources/Private/Templates/Watchlist/Index.html

   <f:if condition="{item.type} == 'CartProducts' && {item.detailPid}">
       <f:then>
           <f:link.page pageUid="{item.detailPid}" additionalParams="{tx_cartproducts_products: {product: item.uid}}">{item.title}</f:link.page>
       </f:then>
       <f:else>
           {item.title}
       </f:else>
   </f:if>

Attention
=========

This feature is only available for TYPO3 v11.

.. index:: Template, Frontend
