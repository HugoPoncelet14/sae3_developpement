<?php

namespace App\Factory;

use App\Entity\Pays;
use App\Repository\PaysRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Pays>
 *
 * @method        Pays|Proxy                     create(array|callable $attributes = [])
 * @method static Pays|Proxy                     createOne(array $attributes = [])
 * @method static Pays|Proxy                     find(object|array|mixed $criteria)
 * @method static Pays|Proxy                     findOrCreate(array $attributes)
 * @method static Pays|Proxy                     first(string $sortedField = 'id')
 * @method static Pays|Proxy                     last(string $sortedField = 'id')
 * @method static Pays|Proxy                     random(array $attributes = [])
 * @method static Pays|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PaysRepository|RepositoryProxy repository()
 * @method static Pays[]|Proxy[]                 all()
 * @method static Pays[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Pays[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Pays[]|Proxy[]                 findBy(array $attributes)
 * @method static Pays[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Pays[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PaysFactory extends ModelFactory
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
            'nomPays' => self::faker()->country(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Pays $pays): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Pays::class;
    }
}
