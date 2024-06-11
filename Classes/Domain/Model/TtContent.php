<?php

namespace Extcode\CartProducts\Domain\Model;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class TtContent extends AbstractEntity
{
    protected \DateTime $crdate;
    protected \DateTime $tstamp;
    protected string $contentType;
    protected string $header;
    protected string $headerPosition;
    protected string $bodytext;
    protected int $colPos;
    protected string $image;
    protected int $imagewidth;
    protected int $imageheight;
    protected int $imageorient;
    protected string $imagecaption;
    protected int $imagecols;
    protected int $imageborder;
    protected string $media;
    protected string $layout;
    protected int $cols;
    protected string $subheader;
    protected string $headerLink;
    protected string $imageLink;
    protected string $imageZoom;
    protected string $altText;
    protected string $titleText;
    protected string $headerLayout;
    protected string $listType;
    protected string $records;
    protected string $pages;
    protected string $feGroup;
    protected string $imagecaptionPosition;
    protected string $longdescUrl;
    protected string $menuType;
    protected string $selectKey;
    protected string $fileCollections;
    protected string $filelinkSorting;
    protected string $target;
    protected string $multimedia;
    protected string $piFlexform;
    protected string $accessibilityTitle;
    protected string $accessibilityBypassText;
    protected string $selectedCategories;
    protected string $categoryField;
    protected int $spaceBefore;
    protected int $spaceAfter;
    protected int $imageNoRows;
    protected int $imageEffects;
    protected int $imageCompression;
    protected int $tableBorder;
    protected int $tableCellspacing;
    protected int $tableCellpadding;
    protected int $tableBgColor;
    protected int $sectionIndex;
    protected int $linkToTop;
    protected int $filelinkSize;
    protected int $sectionFrame;
    protected int $date;
    protected int $imageFrames;
    protected int $recursive;
    protected int $rteEnabled;
    protected int $txImpexpOriguid;
    protected int $accessibilityBypass;
    protected int $sysLanguageUid;
    protected int $starttime;
    protected int $endtime;

    public function getCrdate(): \DateTime
    {
        return $this->crdate;
    }

    public function getTstamp(): \DateTime
    {
        return $this->tstamp;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getHeaderPosition(): string
    {
        return $this->headerPosition;
    }

    public function getBodytext(): string
    {
        return $this->bodytext;
    }

    public function getColPos(): int
    {
        return $this->colPos;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getImagewidth(): int
    {
        return $this->imagewidth;
    }

    public function getImageheight(): int
    {
        return $this->imageheight;
    }

    public function getImageorient(): int
    {
        return $this->imageorient;
    }

    public function getImagecaption(): string
    {
        return $this->imagecaption;
    }

    public function getImagecols(): int
    {
        return $this->imagecols;
    }

    public function getImageborder(): int
    {
        return $this->imageborder;
    }

    public function getMedia(): string
    {
        return $this->media;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function getCols(): int
    {
        return $this->cols;
    }

    public function getSubheader(): string
    {
        return $this->subheader;
    }

    public function getHeaderLink(): string
    {
        return $this->headerLink;
    }

    public function getImageLink(): string
    {
        return $this->imageLink;
    }

    public function getImageZoom(): string
    {
        return $this->imageZoom;
    }

    public function getAltText(): string
    {
        return $this->altText;
    }

    public function getTitleText(): string
    {
        return $this->titleText;
    }

    public function getHeaderLayout(): string
    {
        return $this->headerLayout;
    }

    public function getListType(): string
    {
        return $this->listType;
    }

    public function getRecords(): string
    {
        return $this->records;
    }

    public function getPages(): string
    {
        return $this->pages;
    }

    public function getFeGroup(): string
    {
        return $this->feGroup;
    }

    public function getImagecaptionPosition(): string
    {
        return $this->imagecaptionPosition;
    }

    public function getLongdescUrl(): string
    {
        return $this->longdescUrl;
    }

    public function getMenuType(): string
    {
        return $this->menuType;
    }

    public function getSelectKey(): string
    {
        return $this->selectKey;
    }

    public function getFileCollections(): string
    {
        return $this->fileCollections;
    }

    public function getFilelinkSorting(): string
    {
        return $this->filelinkSorting;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function getMultimedia(): string
    {
        return $this->multimedia;
    }

    public function getPiFlexform()
    {
        return $this->piFlexform;
    }

    public function getAccessibilityTitle(): string
    {
        return $this->accessibilityTitle;
    }

    public function getAccessibilityBypassText(): string
    {
        return $this->accessibilityBypassText;
    }

    public function getSelectedCategories(): string
    {
        return $this->selectedCategories;
    }

    public function getCategoryField(): string
    {
        return $this->categoryField;
    }

    public function getSpaceBefore(): int
    {
        return $this->spaceBefore;
    }

    public function getSpaceAfter(): int
    {
        return $this->spaceAfter;
    }

    public function getImageNoRows(): int
    {
        return $this->imageNoRows;
    }

    public function getImageEffects(): int
    {
        return $this->imageEffects;
    }

    public function getImageCompression(): int
    {
        return $this->imageCompression;
    }

    public function getTableBorder(): int
    {
        return $this->tableBorder;
    }

    public function getTableCellspacing(): int
    {
        return $this->tableCellspacing;
    }

    public function getTableCellpadding(): int
    {
        return $this->tableCellpadding;
    }

    public function getTableBgColor(): int
    {
        return $this->tableBgColor;
    }

    public function getSectionIndex(): int
    {
        return $this->sectionIndex;
    }

    public function getLinkToTop(): int
    {
        return $this->linkToTop;
    }

    public function getFilelinkSize(): int
    {
        return $this->filelinkSize;
    }

    public function getSectionFrame(): int
    {
        return $this->sectionFrame;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function getImageFrames(): int
    {
        return $this->imageFrames;
    }

    public function getRecursive(): int
    {
        return $this->recursive;
    }

    public function getRteEnabled(): int
    {
        return $this->rteEnabled;
    }

    public function getTxImpexpOriguid(): int
    {
        return $this->txImpexpOriguid;
    }

    public function getAccessibilityBypass(): int
    {
        return $this->accessibilityBypass;
    }

    public function getSysLanguageUid(): int
    {
        return $this->sysLanguageUid;
    }

    public function getStarttime(): int
    {
        return $this->starttime;
    }

    public function getEndtime(): int
    {
        return $this->endtime;
    }
}
