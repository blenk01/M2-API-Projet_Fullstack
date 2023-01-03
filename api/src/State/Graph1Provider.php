<?php

namespace App\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\ArrayPaginator;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Graph1Data;
use App\Repository\SaleRepository;

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

            $currentPage = $uriVariables["page"] ?? 1;
            if ( $currentPage < 1 ) $currentPage = 1;

            $sales = $this->saleRepository->findByGroupedByDateAndAvgValue();
            $data = [];
            foreach($sales as $sale) {
                $graph1Data = new Graph1Data($sale['soldAt']->format("d/m/Y"), $sale['moyValue']);
                array_push($data, $graph1Data);
            }

            return new ArrayPaginator($data, self::NB_ITEMS_PER_PAGE * ($currentPage - 1), self::NB_ITEMS_PER_PAGE);
        }

        return null;
    }
}
