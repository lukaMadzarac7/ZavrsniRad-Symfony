<?php

namespace App\Factory;

use App\Entity\UserRating;
use App\Repository\UserRatingRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<UserRating>
 *
 * @method        UserRating|Proxy                     create(array|callable $attributes = [])
 * @method static UserRating|Proxy                     createOne(array $attributes = [])
 * @method static UserRating|Proxy                     find(object|array|mixed $criteria)
 * @method static UserRating|Proxy                     findOrCreate(array $attributes)
 * @method static UserRating|Proxy                     first(string $sortedField = 'id')
 * @method static UserRating|Proxy                     last(string $sortedField = 'id')
 * @method static UserRating|Proxy                     random(array $attributes = [])
 * @method static UserRating|Proxy                     randomOrCreate(array $attributes = [])
 * @method static UserRatingRepository|RepositoryProxy repository()
 * @method static UserRating[]|Proxy[]                 all()
 * @method static UserRating[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static UserRating[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static UserRating[]|Proxy[]                 findBy(array $attributes)
 * @method static UserRating[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static UserRating[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class UserRatingFactory extends ModelFactory
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
            'rating' => RatingFactory::new(),
            'user' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(UserRating $userRating): void {})
        ;
    }

    protected static function getClass(): string
    {
        return UserRating::class;
    }
}
