.. include:: ../../Includes.txt

=========================================================
Breaking: #288 - Removal of the Unfinished Backend Module
=========================================================

See :issue:`288`

Description
===========

The backend module didn't offer much more than a customized list view so far. The detail view did not contain a ready
template and did not offer a representation like in the frontend. The list view can also be done via the List Module.

Impact
======

Editors must resort to the list module.

Note
====

If someone cannot do without this backend module, the code can be outsourced to a separate extension.
As an alternative to this module, dashboard widgets are planned, which offer the editor the possibility to see all
products whose stock is very low or which are no longer available.