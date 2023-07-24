<?php

namespace App\Factory;

use App\Entity\ServiceStatus;
use App\Repository\ServiceStatusRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ServiceStatus>
 *
 * @method        ServiceStatus|Proxy                     create(array|callable $attributes = [])
 * @method static ServiceStatus|Proxy                     createOne(array $attributes = [])
 * @method static ServiceStatus|Proxy                     find(object|array|mixed $criteria)
 * @method static ServiceStatus|Proxy                     findOrCreate(array $attributes)
 * @method static ServiceStatus|Proxy                     first(string $sortedField = 'id')
 * @method static ServiceStatus|Proxy                     last(string $sortedField = 'id')
 * @method static ServiceStatus|Proxy                     random(array $attributes = [])
 * @method static ServiceStatus|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ServiceStatusRepository|RepositoryProxy repository()
 * @method static ServiceStatus[]|Proxy[]                 all()
 * @method static ServiceStatus[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ServiceStatus[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static ServiceStatus[]|Proxy[]                 findBy(array $attributes)
 * @method static ServiceStatus[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ServiceStatus[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ServiceStatusFactory extends ModelFactory
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
            'status' => self::faker()->text(7),

        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ServiceStatus $serviceStatus): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ServiceStatus::class;
    }
}
