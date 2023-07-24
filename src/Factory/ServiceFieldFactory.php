<?php

namespace App\Factory;

use App\Entity\ServiceField;
use App\Repository\ServiceFieldRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ServiceField>
 *
 * @method        ServiceField|Proxy                     create(array|callable $attributes = [])
 * @method static ServiceField|Proxy                     createOne(array $attributes = [])
 * @method static ServiceField|Proxy                     find(object|array|mixed $criteria)
 * @method static ServiceField|Proxy                     findOrCreate(array $attributes)
 * @method static ServiceField|Proxy                     first(string $sortedField = 'id')
 * @method static ServiceField|Proxy                     last(string $sortedField = 'id')
 * @method static ServiceField|Proxy                     random(array $attributes = [])
 * @method static ServiceField|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ServiceFieldRepository|RepositoryProxy repository()
 * @method static ServiceField[]|Proxy[]                 all()
 * @method static ServiceField[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ServiceField[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static ServiceField[]|Proxy[]                 findBy(array $attributes)
 * @method static ServiceField[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ServiceField[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ServiceFieldFactory extends ModelFactory
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
            'created_at' => self::faker()->dateTime(),
            'field' => self::faker()->text(5),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ServiceField $serviceField): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ServiceField::class;
    }
}
