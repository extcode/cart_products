.. include:: ../../Includes.rst.txt

=======================================================
Breaking: #200 - Frontend user removed from detail view
=======================================================

See `Issue 200 <https://github.com/extcode/cart_products/issues/200>`__

Description
===========

The view for detail pages (`/Resources/Private/Template/Show.html`) got the
Frontend user from the controller which was never used. Due to missing usage
the user is no longer given.

Affected Installations
======================

All existing installations that uses the Frontend user in customized templates.

.. index:: Template, Frontend
