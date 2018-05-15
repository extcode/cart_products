<?php

namespace Extcode\CartProducts\ViewHelpers\Backend;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class EditRecordViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes the arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('parameters', 'string', 'Is a set of GET params to send to FormEngine', true);
    }

    /**
     * Returns a URL to link to FormEngine
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @see \TYPO3\CMS\Backend\Utility\BackendUtility::getModuleUrl()
     * @return string URL to FormEngine module + parameters
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $parameters = GeneralUtility::explodeUrl2Array($arguments['parameters']);
        return BackendUtility::getModuleUrl('record_edit', $parameters);
    }
}
