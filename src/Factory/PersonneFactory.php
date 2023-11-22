<?php

namespace App\Factory;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Personne>
 *
 * @method        Personne|Proxy create(array|callable $attributes = [])
 * @method static Personne|Proxy createOne(array $attributes = [])
 * @method static Personne|Proxy find(object|array|mixed $criteria)
 * @method static Personne|Proxy findOrCreate(array $attributes)
 * @method static Personne|Proxy first(string $sortedField = 'id')
 * @method static Personne|Proxy last(string $sortedField = 'id')
 * @method static Personne|Proxy random(array $attributes = [])
 * @method static Personne|Proxy randomOrCreate(array $attributes = [])
 * @method static PersonneRepository|RepositoryProxy repository()
 * @method static Personne[]|Proxy[] all()
 * @method static Personne[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Personne[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Personne[]|Proxy[] findBy(array $attributes)
 * @method static Personne[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Personne[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PersonneFactory extends ModelFactory
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
        $nom = self::faker()->lastName(50);
        $pnom = self::faker()->lastName(50);
        $pseudo = "$pnom-$nom";

        return [
            'SHA512PASS' => self::faker()->sha256(),
            'dateNais' => self::faker()->dateTime(),
            'nomPers' => $nom,
            'pnomPers' => $pnom,
            'pseudo' => $pseudo,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Personne $personne): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Personne::class;
    }
}
