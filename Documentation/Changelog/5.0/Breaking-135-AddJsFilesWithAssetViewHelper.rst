.. include:: ../../Includes.txt

==================================================
Breaking: #135 - Add JS files with AssetViewHelper
==================================================

See :issue:`135`

Description
===========

EXT:cart v9 uses modularized JavaScript without jQuery (see
:ref:` [TASK] Switch from jQuery to vanilla JavaScript #438 <https://github.com/extcode/cart/pull/438>`).

This allows to add the JavaScript only on pages where it's really needed which
is good for performance. The JavaScript is for detail pages is now loaded with
the TYPO3 :ref:`Asset.script ViewHelper<https://docs.typo3.org/other/typo3/view-helper-reference/12.4/en-us/typo3/fluid/latest/Asset/Script.html>`.

Affected Installations
======================

All installations which overwrite
`Resources/Private/Partials/Product/CartForm.html` are affected.
When using the `CartForm.html` which comes with this extension it will work
without any changes.

Migration
=========

The JavaScript in EXT:cart is no longer added via TypoScript. All JavaScript
files are now added via ViewHelper.

Two ViewHelpers needs to be added in `Resources/Private/Partials/Product/CartForm.html`:
 * `<f:asset.script identifier="add-to-cart" src="EXT:cart/Resources/Public/JavaScript/add_to_cart.js" />`
 * `<f:asset.script identifier="change-be-variant" src="EXT:cart/Resources/Public/JavaScript/change_be_variant.js" />` (only when working with BE Variants).

.. index:: Template, Frontend
