<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Graph1Data;
use App\Repository\SaleRepository;
use ArrayObject;

class Graph1Provider implements ProviderInterface
{
    private const NB_ITEMS_PER_PAGE = 30;

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
            
            $sales = $this->saleRepository->getGraph1Data($currentPage, self::NB_ITEMS_PER_PAGE);

            return $sales;
        }

        return null;
    }
}
