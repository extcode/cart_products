<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Tests\Acceptance\Support;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Codappix\Typo3PhpDatasets\PhpDataSet;
use Codeception\Event\SuiteEvent;
use TYPO3\TestingFramework\Core\Acceptance\Extension\BackendEnvironment;

final class Environment extends BackendEnvironment
{
    protected $localConfig = [
        'coreExtensionsToLoad' => [
            'typo3/cms-core',
            'typo3/cms-backend',
            'typo3/cms-extbase',
            'typo3/cms-frontend',
            'typo3/cms-fluid',
            'typo3/cms-fluid-styled-content',
            'typo3/cms-install',
            'typo3/cms-reactions',
        ],
        'testExtensionsToLoad' => [
            'extcode/cart',
            'extcode/cart-products',
            __DIR__ . '/../../Fixtures/cart_products_test',
        ],
        'phpDatabaseFixtures' => [
            'typo3conf/ext/cart_products/Tests/Fixtures/BackendUserDatabase.php',
            'typo3conf/ext/cart_products/Tests/Fixtures/PagesDatabase.php',
            'typo3conf/ext/cart_products/Tests/Fixtures/ContentDatabase.php',
            'typo3conf/ext/cart_products/Tests/Fixtures/ProductsDatabase.php',
        ],
        'pathsToLinkInTestInstance' => [
            'typo3conf/ext/cart_products/Tests/Fixtures/config/sites' => 'typo3conf/sites',
        ],
        'configurationToUseInTestInstance' => [
            'SYS' => [
                'trustedHostsPattern' => '.*',
            ],
        ],
    ];

    public function bootstrapTypo3Environment(SuiteEvent $suiteEvent): void
    {
        parent::bootstrapTypo3Environment($suiteEvent);

        assert(is_array($this->config['phpDatabaseFixtures']));
        foreach ($this->config['phpDatabaseFixtures'] as $dataSetFile) {
            (new PhpDataSet())->import(include $dataSetFile);
        }
    }
}
