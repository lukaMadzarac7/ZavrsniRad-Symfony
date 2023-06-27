<?php

namespace App\Factory;

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
            'city_id' => self::faker()->randomNumber(1),
            'country_id' => self::faker()->randomNumber(1),
            'county_id' => self::faker()->randomNumber(1),
            'created_at' => self::faker()->dateTime(),
            'creator_id' => self::faker()->randomNumber(1),
            'deadline' => self::faker()->dateTime(),
            'description' => self::faker()->text(),
            'owner_id' => self::faker()->randomNumber(1),
            'price' => self::faker()->randomNumber(),
            'service_field_id' => self::faker()->randomNumber(2),
            'service_status_id' => self::faker()->randomNumber(1),
            'service_type_id' => self::faker()->randomNumber(1),
            'title' => self::faker()->text(20),
            'updater_id' => self::faker()->randomNumber(1),
            'valid_till' => self::faker()->dateTime(),
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
