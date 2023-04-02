<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\FrontendUser;
use Extcode\Cart\Domain\Repository\FrontendUserRepository;
use Extcode\Cart\Event\RetrieveProductsFromRequestEvent;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class RetrieveProductsFromRequest
{
    private EventDispatcherInterface $eventDispatcher;

    protected ProductRepository $productRepository;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ProductRepository $productRepository
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->productRepository = $productRepository;
    }

    public function __invoke(RetrieveProductsFromRequestEvent $event): void
    {
        $request = $event->getRequest();
        $taxClasses = $event->getCart()->getTaxClasses();
        $requestArguments = $request->getArguments();

        if ($requestArguments['productType'] !== 'CartProducts') {
            return;
        }

        $frontendUserGroupIds = $this->getFrontendUserGroupIds();

        $createEvent = new \Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent($request, $taxClasses);
        $createEvent->setFrontendUserGroupIds($frontendUserGroupIds);
        $this->eventDispatcher->dispatch($createEvent);

        $errors = $createEvent->getErrors();
        if (!empty($errors)) {
            $event->setErrors($errors);
            $event->setPropagationStopped(true);
            return;
        }

        $event->addProduct($createEvent->getCartProduct());
    }

    /**
     * Get Frontend User Group
     */
    protected function getFrontendUserGroupIds(): array
    {
        $feGroupIds = [];

        $user = $GLOBALS['TSFE']->fe_user->user;
        if (!$user || !(int)$user['uid']) {
            return $feGroupIds;
        }

        $feGroups = $this->getFeGroups((int)$user['uid']);
        if ($feGroups) {
            foreach ($feGroups as $feGroup) {
                $feGroupIds[] = $feGroup->getUid();
            }
        }

        return $feGroupIds;
    }

    protected function getFeGroups(int $uid): ?ObjectStorage
    {
        $frontendUserRepository = GeneralUtility::makeInstance(
            FrontendUserRepository::class
        );
        $feUser = $frontendUserRepository->findByUid((int)$uid);
        if (!$feUser instanceof FrontendUser) {
            return null;
        }

        return $feUser->getUsergroup();
    }
}
