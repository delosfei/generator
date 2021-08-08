<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mobile' => '135'.$this->faker->randomNumber(8, true),
            'name' => $this->faker->word,
            'email' => $this->faker->unique()->safeEmail,
            'real_name' => $this->faker->word,
            'password' => Hash::make('admin888'),
            'home' => $this->faker->word,
            'avatar' => $this->faker->word,
            'wechat' => $this->faker->word,
            'group_id' => $this->faker->randomDigitNotNull,
            'email_verified_at' => $this->faker->date('Y-m-d H:i:s'),
            'mobile_verified_at' => $this->faker->date('Y-m-d H:i:s'),
            'favour_count' => $this->faker->randomDigitNotNull,
            'favorite_count' => $this->faker->randomDigitNotNull,
            'remember_token' => Str::random(10),
            'lock' => $this->faker->randomElement(['0', '1']),
            'ren' => $this->faker->randomDigitNotNull,
            'yi' => $this->faker->randomDigitNotNull,
            'li' => $this->faker->randomDigitNotNull,
            'zhi' => $this->faker->randomDigitNotNull,
            'xin' => $this->faker->randomDigitNotNull,
            'score' => $this->faker->randomDigitNotNull,
            'is_super_admin' => $this->faker->randomElement(['0', '1']),
            'current_team_id' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
