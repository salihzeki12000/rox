<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Persistence\ManagerRegistry;

final class DatabaseContext implements Context
{
    private SchemaTool $schemaTool;
    private array $classes;

    public function __construct(ManagerRegistry $registry)
    {
        $entityManager = $registry->getManager();

        $this->schemaTool = new SchemaTool($entityManager);
        $this->classes = $entityManager->getMetadataFactory()->getAllMetadata();
    }

    /**
     * @BeforeScenario
     */
    public function createSchema(): void
    {
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * @AfterScenario
     */
    public function dropSchema(): void
    {
        $this->schemaTool->dropSchema($this->classes);
    }
}
