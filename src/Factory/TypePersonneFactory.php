<?php

namespace App\Factory;

use App\Entity\TypePersonne;
use App\Repository\TypePersonneRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<TypePersonne>
 *
 * @method        TypePersonne|Proxy create(array|callable $attributes = [])
 * @method static TypePersonne|Proxy createOne(array $attributes = [])
 * @method static TypePersonne|Proxy find(object|array|mixed $criteria)
 * @method static TypePersonne|Proxy findOrCreate(array $attributes)
 * @method static TypePersonne|Proxy first(string $sortedField = 'id')
 * @method static TypePersonne|Proxy last(string $sortedField = 'id')
 * @method static TypePersonne|Proxy random(array $attributes = [])
 * @method static TypePersonne|Proxy randomOrCreate(array $attributes = [])
 * @method static TypePersonneRepository|RepositoryProxy repository()
 * @method static TypePersonne[]|Proxy[] all()
 * @method static TypePersonne[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static TypePersonne[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static TypePersonne[]|Proxy[] findBy(array $attributes)
 * @method static TypePersonne[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TypePersonne[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class TypePersonneFactory extends ModelFactory
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
            'nomTpPers' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(TypePersonne $typePersonne): void {})
        ;
    }

    protected static function getClass(): string
    {
        return TypePersonne::class;
    }
}
