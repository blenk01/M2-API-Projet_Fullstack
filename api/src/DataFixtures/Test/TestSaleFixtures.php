<?php

namespace App\DataFixtures\Test;

use App\Factory\SaleFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestSaleFixtures extends Fixture
{   
    private SaleFactory $saleFactory;

    public function __construct(SaleFactory $saleFactory)
    {
        $this->saleFactory = $saleFactory;
    }

    public function load(ObjectManager $manager): void
    {        
        for($i = 0; $i < 10; $i++) {
            $this->saleFactory->createOne();
        }
    }
}
