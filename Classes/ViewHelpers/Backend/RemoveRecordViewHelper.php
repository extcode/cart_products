<?php
namespace Extcode\CartProducts\ViewHelpers\Backend;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class RemoveRecordViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Initializes the arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('product', \Extcode\CartProducts\Domain\Model\Product\Product::class, 'product to remove', true);
    }

    /**
     * Render link with sprite icon to remove product
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $product = $arguments['product'];

        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);

        $urlParameters = [
            'cmd[tx_cartproducts_domain_model_product_product][' . $product->getUid() . '][delete]' => 1,
            'prErr' => 1,
            'uPT' => 1,
            'redirect' => GeneralUtility::getIndpEnv('REQUEST_URI')
        ];
        $url = BackendUtility::getModuleUrl('tce_db', $urlParameters);

        return '<a class="btn btn-default t3js-modal-trigger" href="' . htmlspecialchars($url) . '"'
            . ' title="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:tx_cartproducts.module.products.action.delete_record.title')) . '"'
            . ' data-severity="warning"'
            . ' data-title="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/Resources/Private/Language/locallang_alt_doc.xlf:label.confirm.delete_record.title')) . '"'
            . ' data-content="' . htmlspecialchars(LocalizationUtility::translate('confirm', 'translation', [$product->getUid()])) . '" '
            . ' data-button-close-text="' . htmlspecialchars($GLOBALS['LANG']->sL('LLL:EXT:lang/Resources/Private/Language/locallang_common.xlf:cancel')) . '"'
            . '>' . $iconFactory->getIcon('actions-edit-delete', Icon::SIZE_SMALL)->render() . '</a>';
    }
}
