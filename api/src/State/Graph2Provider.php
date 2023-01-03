<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\SaleRepository;
use DateTime;

class Graph2Provider implements ProviderInterface
{
    private SaleRepository $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            $currentPage = $context["filters"]["page"] ?? 1;
            if ( $currentPage < 1 ) $currentPage = 1;

            $startAt = DateTime::createFromFormat('d-m-Y', $context["filters"]["startAt"]) ?? new DateTime();
            $endAt = DateTime::createFromFormat('d-m-Y', $context["filters"]["endAt"]) ?? new DateTime();
            
            $sales = $this->saleRepository->getNbVenteFilterDates($startAt, $endAt);

            return $sales;
        }

        return null;
    }
}
