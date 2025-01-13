<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

/**
 * @extends Factory<User>
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
     * @throws NumberParseException Если номер телефона не может быть распознан.
     */
    public function definition(): array
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        $randomPhoneNumber = $this->faker->e164PhoneNumber();
        $numberProto = $phoneUtil->parse($randomPhoneNumber, 'US');
        $formattedPhoneNumber = $phoneUtil->format($numberProto, PhoneNumberFormat::E164);

        return [
            'id' => fake()->uuid(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified' => fake()->boolean() ? 1 : 0,
            'full_name' => fake()->name(),
            'address' => fake()->address(),
            'phone_number' => $formattedPhoneNumber,
            'password' => static::$password ??= Hash::make('password'),
            'provider_type' => fake()->randomElement(['GOOGLE', 'FACEBOOK', 'LOCAL']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
