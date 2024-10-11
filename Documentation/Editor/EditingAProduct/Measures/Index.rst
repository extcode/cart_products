.. include:: ../../../Includes.rst.txt

========
Measures
========

Concept of Measures
===================

When selling products in different quantities (e.g. 0.5 kg, 1 kg, 5 kg) it can
be a legal demand to indicate the base price to make it possible for customers
to compare the different quantities ('value-for-money ratio').

The three fields in this group are used together. The following example shows
the usage. To stay with the example from
above you might enter:

* Price = 10 € (defined in the tab :guilabel:`Prices`).
* Price Measure = 200
* Price Measure Unit = g
* Base Price Measure Unit = kg

Which will result in 50 €/kg.

.. NOTE::
   For products with BE variants these values have to be entered for every
   BE variant.

   The default output is minimalistic and needs adaption to be really useful.

Concept of Service Attributes
=============================

Entering something in the service attribute fields does not have any effect by
default. These fields provide a base to implement individual functionality. An
example might be the best way to show the potential:

Example 'Output weight and dimensions'
--------------------------------------

Simply display the weight and the dimensions of the product in the frontend.

* Use field :guilabel:`Service Attribute 1` and overwrite its label with
  'Weight'.
* Use field :guilabel:`Service Attribute 2` and overwrite its label with
  'Dimensions'
* Suppress the output of :guilabel:`Service Attribute 2` to not confuse
  editors.
* Output the weight and dimensions in the detail view
  (`/Resources/Private/Templates/Product/Show.html`) with
  `{product.serviceAttribute1}` and `{product.serviceAttribute2}`.

Example 'Shipping costs depending on total weight of order'
-----------------------------------------------------------

The shipping costs shall depend on the weight of the sum of all products in the
order.

* Use field :guilabel:`Service Attribute 1` and overwrite its label with
  'Weight'.
* Suppress the output of the other two fields to not confuse editors.
* Set in TypoScript (here for Germany (`de`))
  `plugin.tx_cart.shipping.countries.de.options.1.extra = by_service_attribute_1_sum`
* Set the child values (see EXT:cart documentation, section 'Flexible prices for
  shipping').


More advanced scenarios are possible by adding an own ServiceInterface (see
EXT:cart documentation, section 'Flexible prices for shipping').
