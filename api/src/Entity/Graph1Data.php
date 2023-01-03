<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\Graph1Provider;
use DateTime;

#[ApiResource(paginationEnabled: false)]
#[GetCollection(
    provider: Graph1Provider::class
)]
class Graph1Data
{
    private ?DateTime $datetime = null;
    private ?float $value = null;

    public function __construct(DateTime $datetime, string $value)
    {
        $this->datetime = $datetime;
        $this->value = round($value, 2);
    }

    public function getDatetime(): string {
        return $this->datetime->format('d-m-Y');
    }

    public function getValue(): float {
        return $this->value;
    }
}
