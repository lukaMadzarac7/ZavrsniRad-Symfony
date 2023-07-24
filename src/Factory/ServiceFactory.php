<?php

namespace App\Factory;

use App\Entity\City;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Service>
 *
 * @method        Service|Proxy                     create(array|callable $attributes = [])
 * @method static Service|Proxy                     createOne(array $attributes = [])
 * @method static Service|Proxy                     find(object|array|mixed $criteria)
 * @method static Service|Proxy                     findOrCreate(array $attributes)
 * @method static Service|Proxy                     first(string $sortedField = 'id')
 * @method static Service|Proxy                     last(string $sortedField = 'id')
 * @method static Service|Proxy                     random(array $attributes = [])
 * @method static Service|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ServiceRepository|RepositoryProxy repository()
 * @method static Service[]|Proxy[]                 all()
 * @method static Service[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Service[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Service[]|Proxy[]                 findBy(array $attributes)
 * @method static Service[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Service[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ServiceFactory extends ModelFactory
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
            'adress' => self::faker()->text(10),
            'city' => CityFactory::new(),
            'county' => CountyFactory::new(),
            'country' => CountryFactory::new(),
            'created_at' => self::faker()->dateTime('now'),
            'deadline' => self::faker()->dateTimeBetween('now', '3 months'),
            'description' => self::faker()->text(),
            'price' => self::faker()->numberBetween(10, 1000),
            'title' => self::faker()->text(20),
            'valid_till' => self::faker()->dateTime(),
            'owner' => UserFactory::new(),
            'updater' => UserFactory::new(),
            'creator' => UserFactory::new(),
            'service_status' => ServiceStatusFactory::new(),
            'service_type' => ServiceTypeFactory::new(),
            'service_field' => ServiceFieldFactory::new(),




        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Service $service): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Service::class;
    }
}
