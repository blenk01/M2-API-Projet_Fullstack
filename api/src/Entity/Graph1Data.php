<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\Graph1Provider;

#[ApiResource()]
#[GetCollection(
    provider: Graph1Provider::class
)]
class Graph1Data
{
    private ?string $datetime = null;
    private ?float $value = null;

    public function __construct(string $datetime, string $value)
    {
        $this->datetime = $datetime;
        $this->value = $value;
    }

    public function getDatetime(): string {
        return $this->datetime;
    }

    public function getValue(): float {
        return $this->value;
    }
}
