<?php

namespace App\Factory;

use App\Entity\Sale;
use App\Repository\SaleRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Sale>
 *
 * @method        Sale|Proxy create(array|callable $attributes = [])
 * @method static Sale|Proxy createOne(array $attributes = [])
 * @method static Sale|Proxy find(object|array|mixed $criteria)
 * @method static Sale|Proxy findOrCreate(array $attributes)
 * @method static Sale|Proxy first(string $sortedField = 'id')
 * @method static Sale|Proxy last(string $sortedField = 'id')
 * @method static Sale|Proxy random(array $attributes = [])
 * @method static Sale|Proxy randomOrCreate(array $attributes = [])
 * @method static SaleRepository|RepositoryProxy repository()
 * @method static Sale[]|Proxy[] all()
 * @method static Sale[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Sale[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Sale[]|Proxy[] findBy(array $attributes)
 * @method static Sale[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Sale[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class SaleFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'codeDepartement' => self::faker()->randomElement(array_merge(range(1, 95), [971, 972, 973, 974, 976, "2A", "2B"])),
            'soldAt' => self::faker()->dateTime(),
            'surface' => self::faker()->randomNumber(2),
            'value' => self::faker()->randomFloat(2),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Sale $sale): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Sale::class;
    }
}
