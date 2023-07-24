<?php

namespace App\Factory;

use App\Entity\ServiceImage;
use App\Repository\ServiceImageRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ServiceImage>
 *
 * @method        ServiceImage|Proxy                     create(array|callable $attributes = [])
 * @method static ServiceImage|Proxy                     createOne(array $attributes = [])
 * @method static ServiceImage|Proxy                     find(object|array|mixed $criteria)
 * @method static ServiceImage|Proxy                     findOrCreate(array $attributes)
 * @method static ServiceImage|Proxy                     first(string $sortedField = 'id')
 * @method static ServiceImage|Proxy                     last(string $sortedField = 'id')
 * @method static ServiceImage|Proxy                     random(array $attributes = [])
 * @method static ServiceImage|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ServiceImageRepository|RepositoryProxy repository()
 * @method static ServiceImage[]|Proxy[]                 all()
 * @method static ServiceImage[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static ServiceImage[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static ServiceImage[]|Proxy[]                 findBy(array $attributes)
 * @method static ServiceImage[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static ServiceImage[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ServiceImageFactory extends ModelFactory
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
            'image' => self::faker()->text(),
            'service' => ServiceFactory::new(),

        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ServiceImage $serviceImage): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ServiceImage::class;
    }
}
