<?php

namespace App\Factory;

use App\Entity\Quantite;
use App\Repository\QuantiteRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Quantite>
 *
 * @method        Quantite|Proxy create(array|callable $attributes = [])
 * @method static Quantite|Proxy createOne(array $attributes = [])
 * @method static Quantite|Proxy find(object|array|mixed $criteria)
 * @method static Quantite|Proxy findOrCreate(array $attributes)
 * @method static Quantite|Proxy first(string $sortedField = 'id')
 * @method static Quantite|Proxy last(string $sortedField = 'id')
 * @method static Quantite|Proxy random(array $attributes = [])
 * @method static Quantite|Proxy randomOrCreate(array $attributes = [])
 * @method static QuantiteRepository|RepositoryProxy repository()
 * @method static Quantite[]|Proxy[] all()
 * @method static Quantite[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Quantite[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Quantite[]|Proxy[] findBy(array $attributes)
 * @method static Quantite[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Quantite[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class QuantiteFactory extends ModelFactory
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
            'quantite' => self::faker()->randomFloat(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Quantite $quantite): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Quantite::class;
    }
}
