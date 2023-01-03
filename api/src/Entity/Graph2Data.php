<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\Graph2Provider;
use DateTime;

#[ApiResource(paginationEnabled: false)]
#[GetCollection(
    provider: Graph2Provider::class
)]
class Graph2Data
{
    private DateTime $datetime;
    private int $nbVente;

    public function __construct(DateTime $datetime, int $nbVente)
    {
        $this->datetime = $datetime;
        $this->nbVente = $nbVente;
    }

    public function getDatetime(): string {
        return $this->datetime->format('d-m-Y');
    }

    public function getNbVente(): int {
        return $this->nbVente;
    }
}
