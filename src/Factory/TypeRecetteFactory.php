<?php

namespace App\Factory;

use App\Entity\TypeRecette;
use App\Repository\TypeRecetteRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<TypeRecette>
 *
 * @method        TypeRecette|Proxy create(array|callable $attributes = [])
 * @method static TypeRecette|Proxy createOne(array $attributes = [])
 * @method static TypeRecette|Proxy find(object|array|mixed $criteria)
 * @method static TypeRecette|Proxy findOrCreate(array $attributes)
 * @method static TypeRecette|Proxy first(string $sortedField = 'id')
 * @method static TypeRecette|Proxy last(string $sortedField = 'id')
 * @method static TypeRecette|Proxy random(array $attributes = [])
 * @method static TypeRecette|Proxy randomOrCreate(array $attributes = [])
 * @method static TypeRecetteRepository|RepositoryProxy repository()
 * @method static TypeRecette[]|Proxy[] all()
 * @method static TypeRecette[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static TypeRecette[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static TypeRecette[]|Proxy[] findBy(array $attributes)
 * @method static TypeRecette[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TypeRecette[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class TypeRecetteFactory extends ModelFactory
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
            'nomTpRec' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(TypeRecette $typeRecette): void {})
        ;
    }

    protected static function getClass(): string
    {
        return TypeRecette::class;
    }
}
