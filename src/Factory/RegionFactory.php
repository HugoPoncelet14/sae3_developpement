<?php

namespace App\Factory;

use App\Entity\Region;
use App\Repository\RegionRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Region>
 *
 * @method        Region|Proxy                     create(array|callable $attributes = [])
 * @method static Region|Proxy                     createOne(array $attributes = [])
 * @method static Region|Proxy                     find(object|array|mixed $criteria)
 * @method static Region|Proxy                     findOrCreate(array $attributes)
 * @method static Region|Proxy                     first(string $sortedField = 'id')
 * @method static Region|Proxy                     last(string $sortedField = 'id')
 * @method static Region|Proxy                     random(array $attributes = [])
 * @method static Region|Proxy                     randomOrCreate(array $attributes = [])
 * @method static RegionRepository|RepositoryProxy repository()
 * @method static Region[]|Proxy[]                 all()
 * @method static Region[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Region[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Region[]|Proxy[]                 findBy(array $attributes)
 * @method static Region[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Region[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class RegionFactory extends ModelFactory
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
        $nom = self::faker()->word(10);

        return [
            'nomReg' => "Region {$nom}",
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Region $region): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Region::class;
    }
}
