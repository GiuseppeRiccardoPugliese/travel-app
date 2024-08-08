<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

//Faker per gli User in Italiano
use Faker\Provider\it_IT\Person;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        //Dati User Formato Italiano
        $this->faker->addProvider(new Person($this->faker));
        $gender = $this->faker->randomElement(['male', 'female']);
        $faker = FakerFactory::create('it_IT');
        $lastname = $this->faker->lastName();
        $name = $this->faker->firstName($gender);

        return [
            'name' => $name . ' ' . $lastname,
            'email' => $name . '.' . $lastname.trim(' ') . fake()->numberBetween(1, 9) . '@example.com',
            'sessualità' => $gender == 'male' ? 'uomo' : 'donna',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
