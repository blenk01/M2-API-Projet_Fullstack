<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Sale;
use Doctrine\ORM\EntityManagerInterface;

class SalesTest extends ApiTestCase
{

    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetSales(): void
    {
        static::createClient()->request('GET', '/sales');

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/contexts/Sale',
            '@type' => 'hydra:Collection',
        ]);
    }

    public function testGetSale(): void
    {
        $sale = $this->entityManager->getRepository(Sale::class)->findOneBy([]);

        static::createClient()->request('GET', sprintf("/sales/%s", $sale->getId()));

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/contexts/Sale',
            '@type' => 'Sale',
            'surface' => $sale->getSurface(),
            'codeDepartement' => $sale->getCodeDepartement(),
            'soldAt' => $sale->getSoldAt()->format("c"),
            'value' => $sale->getValue()
        ]);
    }
}
