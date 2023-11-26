<?php

namespace App\Factory;

use App\Entity\Ingrediant;
use App\Repository\IngrediantRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Ingrediant>
 *
 * @method        Ingrediant|Proxy create(array|callable $attributes = [])
 * @method static Ingrediant|Proxy createOne(array $attributes = [])
 * @method static Ingrediant|Proxy find(object|array|mixed $criteria)
 * @method static Ingrediant|Proxy findOrCreate(array $attributes)
 * @method static Ingrediant|Proxy first(string $sortedField = 'id')
 * @method static Ingrediant|Proxy last(string $sortedField = 'id')
 * @method static Ingrediant|Proxy random(array $attributes = [])
 * @method static Ingrediant|Proxy randomOrCreate(array $attributes = [])
 * @method static IngrediantRepository|RepositoryProxy repository()
 * @method static Ingrediant[]|Proxy[] all()
 * @method static Ingrediant[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Ingrediant[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Ingrediant[]|Proxy[] findBy(array $attributes)
 * @method static Ingrediant[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Ingrediant[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class IngrediantFactory extends ModelFactory
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
            'nomIng' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Ingrediant $ingrediant): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Ingrediant::class;
    }
}
