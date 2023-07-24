<?php

namespace App\Factory;

use App\Entity\UserInformation;
use App\Repository\UserInformationRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<UserInformation>
 *
 * @method        UserInformation|Proxy                     create(array|callable $attributes = [])
 * @method static UserInformation|Proxy                     createOne(array $attributes = [])
 * @method static UserInformation|Proxy                     find(object|array|mixed $criteria)
 * @method static UserInformation|Proxy                     findOrCreate(array $attributes)
 * @method static UserInformation|Proxy                     first(string $sortedField = 'id')
 * @method static UserInformation|Proxy                     last(string $sortedField = 'id')
 * @method static UserInformation|Proxy                     random(array $attributes = [])
 * @method static UserInformation|Proxy                     randomOrCreate(array $attributes = [])
 * @method static UserInformationRepository|RepositoryProxy repository()
 * @method static UserInformation[]|Proxy[]                 all()
 * @method static UserInformation[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static UserInformation[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static UserInformation[]|Proxy[]                 findBy(array $attributes)
 * @method static UserInformation[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static UserInformation[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class UserInformationFactory extends ModelFactory
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
            'user' => UserFactory::new(),
            'city' => CityFactory::new(),
            'county' => CountyFactory::new(),
            'country' => CountryFactory::new(),
            'adress' => self::faker()->text(15),
            'created_at' => self::faker()->dateTime(),
            'phone_number' => self::faker()->numberBetween(10000),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(UserInformation $userInformation): void {})
        ;
    }

    protected static function getClass(): string
    {
        return UserInformation::class;
    }
}
