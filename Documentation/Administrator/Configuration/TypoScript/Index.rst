.. include:: ../../../Includes.rst.txt

==========
TypoScript
==========

The following snippet shows how to set the needed TypoScript parameter by mostly
reusing the parameter that already were set as TypoScript constants format
EXT:cart.

.. code-block:: typoscript
   :caption: e.g. EXT:sitepackage/Configuration/TypoScript/setup.typoscript

    plugin.tx_cartproducts {
        settings {
            cart {
                pid = {$plugin.tx_cart.settings.cart.pid}
                isNetCart = {$plugin.tx_cart.settings.cart.isNetCart}
            }

            order {
                pid = {$plugin.tx_cart.settings.order.pid}
            }

            format.currency < plugin.tx_cart.settings.format.currency

            itemsPerPage = 9
        }
    }

plugin.tx_cartproducts.settings
===============================

The most parameter are described in the documentation of EXT:cart, so here only
the individual parameter are described.

.. confval:: format.currency

   :Type: array
   :Default: The TypoScript template use the setting defined by the constant of the cart extension.

   Configures how prices should be formated in frontend. The
   `\Extcode\Cart\ViewHelpers\Format\CurrencyViewHelper` uses this global
   setting.

.. confval:: itemsPerPage

   :Type: int
   :Default: The default value is 20 if there is no TypoScript configuration.

   Defines how many records should be displayed per page in the list action.
