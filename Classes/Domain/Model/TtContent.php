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
    protected string $txGridelementsBackendLayout;
    protected int $txGridelementsChildren;
    protected int $txGridelementsContainer;
    protected int $txGridelementsColumns;

    public function getCrdate(): \DateTime
    {
        return $this->crdate;
    }

    public function setCrdate(\DateTime $crdate): void
    {
        $this->crdate = $crdate;
    }

    public function getTstamp(): \DateTime
    {
        return $this->tstamp;
    }

    public function setTstamp(\DateTime $tstamp): void
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param $contentType
     */
    public function setContentType($contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param $header
     */
    public function setHeader($header): void
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getHeaderPosition()
    {
        return $this->headerPosition;
    }

    /**
     * @param $headerPosition
     */
    public function setHeaderPosition($headerPosition): void
    {
        $this->headerPosition = $headerPosition;
    }

    /**
     * @return string
     */
    public function getBodytext()
    {
        return $this->bodytext;
    }

    /**
     * @param $bodytext
     */
    public function setBodytext($bodytext): void
    {
        $this->bodytext = $bodytext;
    }

    /**
     * Get the colpos
     *
     * @return int
     */
    public function getColPos()
    {
        return (int)$this->colPos;
    }

    /**
     * Set colpos
     *
     * @param int $colPos
     */
    public function setColPos($colPos): void
    {
        $this->colPos = $colPos;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getImagewidth()
    {
        return $this->imagewidth;
    }

    /**
     * @param $imagewidth
     */
    public function setImagewidth($imagewidth): void
    {
        $this->imagewidth = $imagewidth;
    }

    /**
     * @return int
     */
    public function getImageheight()
    {
        return $this->imageheight;
    }

    /**
     * @param $imageheight
     */
    public function setImageheight($imageheight): void
    {
        $this->imageheight = $imageheight;
    }

    /**
     * @return int
     */
    public function getImageorient()
    {
        return $this->imageorient;
    }

    /**
     * @param $imageorient
     */
    public function setImageorient($imageorient): void
    {
        $this->imageorient = $imageorient;
    }

    /**
     * @return string
     */
    public function getImagecaption()
    {
        return $this->imagecaption;
    }

    /**
     * @param $imagecaption
     */
    public function setImagecaption($imagecaption): void
    {
        $this->imagecaption = $imagecaption;
    }

    /**
     * @return int
     */
    public function getImagecols()
    {
        return $this->imagecols;
    }

    /**
     * @param $imagecols
     */
    public function setImagecols($imagecols): void
    {
        $this->imagecols = $imagecols;
    }

    /**
     * @return int
     */
    public function getImageborder()
    {
        return $this->imageborder;
    }

    /**
     * @param $imageborder
     */
    public function setImageborder($imageborder): void
    {
        $this->imageborder = $imageborder;
    }

    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param $media
     */
    public function setMedia($media): void
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param $layout
     */
    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    /**
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @param $cols
     */
    public function setCols($cols): void
    {
        $this->cols = $cols;
    }

    /**
     * @return string
     */
    public function getSubheader()
    {
        return $this->subheader;
    }

    /**
     * @param $subheader
     */
    public function setSubheader($subheader): void
    {
        $this->subheader = $subheader;
    }

    /**
     * @return string
     */
    public function getHeaderLink()
    {
        return $this->headerLink;
    }

    /**
     * @param $headerLink
     */
    public function setHeaderLink($headerLink): void
    {
        $this->headerLink = $headerLink;
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * @param $imageLink
     */
    public function setImageLink($imageLink): void
    {
        $this->imageLink = $imageLink;
    }

    /**
     * @return string
     */
    public function getImageZoom()
    {
        return $this->imageZoom;
    }

    /**
     * @param $imageZoom
     */
    public function setImageZoom($imageZoom): void
    {
        $this->imageZoom = $imageZoom;
    }

    /**
     * @return string
     */
    public function getAltText()
    {
        return $this->altText;
    }

    /**
     * @param $altText
     */
    public function setAltText($altText): void
    {
        $this->altText = $altText;
    }

    /**
     * @return string
     */
    public function getTitleText()
    {
        return $this->titleText;
    }

    /**
     * @param $titleText
     */
    public function setTitleText($titleText): void
    {
        $this->titleText = $titleText;
    }

    /**
     * @return string
     */
    public function getHeaderLayout()
    {
        return $this->headerLayout;
    }

    /**
     * @param $headerLayout
     */
    public function setHeaderLayout($headerLayout): void
    {
        $this->headerLayout = $headerLayout;
    }

    /**
     * @return string
     */
    public function getListType()
    {
        return $this->listType;
    }

    /**
     * @param string $listType
     */
    public function setListType($listType): void
    {
        $this->listType = $listType;
    }

    /**
     * @return string
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @param $records
     */
    public function setRecords($records): void
    {
        $this->records = $records;
    }

    /**
     * @return string
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param $pages
     */
    public function setPages($pages): void
    {
        $this->pages = $pages;
    }

    /**
     * @return string
     */
    public function getFeGroup()
    {
        return $this->feGroup;
    }

    /**
     * @param $feGroup
     */
    public function setFeGroup($feGroup): void
    {
        $this->feGroup = $feGroup;
    }

    /**
     * @return string
     */
    public function getImagecaptionPosition()
    {
        return $this->imagecaptionPosition;
    }

    /**
     * @param $imagecaptionPosition
     */
    public function setImagecaptionPosition($imagecaptionPosition): void
    {
        $this->imagecaptionPosition = $imagecaptionPosition;
    }

    /**
     * @return string
     */
    public function getLongdescUrl()
    {
        return $this->longdescUrl;
    }

    /**
     * @param $longdescUrl
     */
    public function setLongdescUrl($longdescUrl): void
    {
        $this->longdescUrl = $longdescUrl;
    }

    /**
     * @return string
     */
    public function getMenuType()
    {
        return $this->menuType;
    }

    /**
     * @param $menuType
     */
    public function setMenuType($menuType): void
    {
        $this->menuType = $menuType;
    }

    /**
     * @return string
     */
    public function getSelectKey()
    {
        return $this->selectKey;
    }

    /**
     * @param $selectKey
     */
    public function setSelectKey($selectKey): void
    {
        $this->selectKey = $selectKey;
    }

    /**
     * @return string
     */
    public function getFileCollections()
    {
        return $this->fileCollections;
    }

    /**
     * @param $fileCollections
     */
    public function setFileCollections($fileCollections): void
    {
        $this->fileCollections = $fileCollections;
    }

    /**
     * @return string
     */
    public function getFilelinkSorting()
    {
        return $this->filelinkSorting;
    }

    /**
     * @param $filelinkSorting
     */
    public function setFilelinkSorting($filelinkSorting): void
    {
        $this->filelinkSorting = $filelinkSorting;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param $target
     */
    public function setTarget($target): void
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getMultimedia()
    {
        return $this->multimedia;
    }

    /**
     * @param $multimedia
     */
    public function setMultimedia($multimedia): void
    {
        $this->multimedia = $multimedia;
    }

    /**
     * @return string
     */
    public function getPiFlexform()
    {
        return $this->piFlexform;
    }

    /**
     * @param $piFlexform
     */
    public function setPiFlexform($piFlexform): void
    {
        $this->piFlexform = $piFlexform;
    }

    /**
     * @return string
     */
    public function getAccessibilityTitle()
    {
        return $this->accessibilityTitle;
    }

    /**
     * @param $accessibilityTitle
     */
    public function setAccessibilityTitle($accessibilityTitle): void
    {
        $this->accessibilityTitle = $accessibilityTitle;
    }

    /**
     * @return string
     */
    public function getAccessibilityBypassText()
    {
        return $this->accessibilityBypassText;
    }

    /**
     * @param $accessibilityBypassText
     */
    public function setAccessibilityBypassText($accessibilityBypassText): void
    {
        $this->accessibilityBypassText = $accessibilityBypassText;
    }

    /**string
     * @return string
     */
    public function getSelectedCategories()
    {
        return $this->selectedCategories;
    }

    /**
     * @param $selectedCategories
     */
    public function setSelectedCategories($selectedCategories): void
    {
        $this->selectedCategories = $selectedCategories;
    }

    /**
     * @return string
     */
    public function getCategoryField()
    {
        return $this->categoryField;
    }

    /**
     * @param $categoryField
     */
    public function setCategoryField($categoryField): void
    {
        $this->categoryField = $categoryField;
    }

    /**
     * @return int
     */
    public function getSpaceBefore()
    {
        return $this->spaceBefore;
    }

    /**
     * @param $spaceBefore
     */
    public function setSpaceBefore($spaceBefore): void
    {
        $this->spaceBefore = $spaceBefore;
    }

    /**
     * @return int
     */
    public function getSpaceAfter()
    {
        return $this->spaceAfter;
    }

    /**
     * @param $spaceAfter
     */
    public function setSpaceAfter($spaceAfter): void
    {
        $this->spaceAfter = $spaceAfter;
    }

    /**
     * @return int
     */
    public function getImageNoRows()
    {
        return $this->imageNoRows;
    }

    /**
     * @param $imageNoRows
     */
    public function setImageNoRows($imageNoRows): void
    {
        $this->imageNoRows = $imageNoRows;
    }

    /**
     * @return int
     */
    public function getImageEffects()
    {
        return $this->imageEffects;
    }

    /**
     * @param $imageEffects
     */
    public function setImageEffects($imageEffects): void
    {
        $this->imageEffects = $imageEffects;
    }

    /**
     * @return int
     */
    public function getImageCompression()
    {
        return $this->imageCompression;
    }

    /**
     * @param $imageCompression
     */
    public function setImageCompression($imageCompression): void
    {
        $this->imageCompression = $imageCompression;
    }

    /**
     * @return int
     */
    public function getTableBorder()
    {
        return $this->tableBorder;
    }

    /**
     * @param $tableBorder
     */
    public function setTableBorder($tableBorder): void
    {
        $this->tableBorder = $tableBorder;
    }

    /**
     * @return int
     */
    public function getTableCellspacing()
    {
        return $this->tableCellspacing;
    }

    /**
     * @param $tableCellspacing
     */
    public function setTableCellspacing($tableCellspacing): void
    {
        $this->tableCellspacing = $tableCellspacing;
    }

    /**
     * @return int
     */
    public function getTableCellpadding()
    {
        return $this->tableCellpadding;
    }

    /**
     * @param $tableCellpadding
     */
    public function setTableCellpadding($tableCellpadding): void
    {
        $this->tableCellpadding = $tableCellpadding;
    }

    /**
     * @return int
     */
    public function getTableBgColor()
    {
        return $this->tableBgColor;
    }

    /**
     * @param $tableBgColor
     */
    public function setTableBgColor($tableBgColor): void
    {
        $this->tableBgColor = $tableBgColor;
    }

    /**
     * @return int
     */
    public function getSectionIndex()
    {
        return $this->sectionIndex;
    }

    /**
     * @param $sectionIndex
     */
    public function setSectionIndex($sectionIndex): void
    {
        $this->sectionIndex = $sectionIndex;
    }

    /**
     * @return int
     */
    public function getLinkToTop()
    {
        return $this->linkToTop;
    }

    /**
     * @param $linkToTop
     */
    public function setLinkToTop($linkToTop): void
    {
        $this->linkToTop = $linkToTop;
    }

    /**
     * @return int
     */
    public function getFilelinkSize()
    {
        return $this->filelinkSize;
    }

    /**
     * @param $filelinkSize
     */
    public function setFilelinkSize($filelinkSize): void
    {
        $this->filelinkSize = $filelinkSize;
    }

    /**
     * @return int
     */
    public function getSectionFrame()
    {
        return $this->sectionFrame;
    }

    /**
     * @param $sectionFrame
     */
    public function setSectionFrame($sectionFrame): void
    {
        $this->sectionFrame = $sectionFrame;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getImageFrames()
    {
        return $this->imageFrames;
    }

    /**
     * @param $imageFrames
     */
    public function setImageFrames($imageFrames): void
    {
        $this->imageFrames = $imageFrames;
    }

    /**
     * @return int
     */
    public function getRecursive()
    {
        return $this->recursive;
    }

    /**
     * @param $recursive
     */
    public function setRecursive($recursive): void
    {
        $this->recursive = $recursive;
    }

    /**
     * @return int
     */
    public function getRteEnabled()
    {
        return $this->rteEnabled;
    }

    /**
     * @param $rteEnabled
     */
    public function setRteEnabled($rteEnabled): void
    {
        $this->rteEnabled = $rteEnabled;
    }

    /**
     * @return int
     */
    public function getTxImpexpOriguid()
    {
        return $this->txImpexpOriguid;
    }

    /**
     * @param $txImpexpOriguid
     */
    public function setTxImpexpOriguid($txImpexpOriguid): void
    {
        $this->txImpexpOriguid = $txImpexpOriguid;
    }

    /**
     * @return int
     */
    public function getAccessibilityBypass()
    {
        return $this->accessibilityBypass;
    }

    /**
     * @param $accessibilityBypass
     */
    public function setAccessibilityBypass($accessibilityBypass): void
    {
        $this->accessibilityBypass = $accessibilityBypass;
    }

    /**
     * @return int
     */
    public function getSysLanguageUid()
    {
        return $this->sysLanguageUid;
    }

    /**
     * @param $sysLanguageUid
     */
    public function setSysLanguageUid($sysLanguageUid): void
    {
        $this->sysLanguageUid = $sysLanguageUid;
    }

    /**
     * @return int
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * @param $starttime
     */
    public function setStarttime($starttime): void
    {
        $this->starttime = $starttime;
    }

    /**
     * @return int
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * @param $endtime
     */
    public function setEndtime($endtime): void
    {
        $this->endtime = $endtime;
    }

    /**
     * @return string
     */
    public function getTxGridelementsBackendLayout()
    {
        return $this->txGridelementsBackendLayout;
    }

    /**
     * @param $txGridelementsBackendLayout
     */
    public function setTxGridelementsBackendLayout($txGridelementsBackendLayout): void
    {
        $this->txGridelementsBackendLayout = $txGridelementsBackendLayout;
    }

    /**
     * @return int
     */
    public function getTxGridelementsChildren()
    {
        return $this->txGridelementsChildren;
    }

    /**
     * @param $txGridelementsChildren
     */
    public function setTxGridelementsChildren($txGridelementsChildren): void
    {
        $this->txGridelementsChildren = $txGridelementsChildren;
    }

    /**
     * @return int
     */
    public function getTxGridelementsContainer()
    {
        return $this->txGridelementsContainer;
    }

    /**
     * @param $txGridelementsContainer
     */
    public function setTxGridelementsContainer($txGridelementsContainer): void
    {
        $this->txGridelementsContainer = $txGridelementsContainer;
    }

    /**
     * @return int
     */
    public function getTxGridelementsColumns()
    {
        return $this->txGridelementsColumns;
    }

    /**
     * @param $txGridelementsColumns
     */
    public function setTxGridelementsColumns($txGridelementsColumns): void
    {
        $this->txGridelementsColumns = $txGridelementsColumns;
    }
}
